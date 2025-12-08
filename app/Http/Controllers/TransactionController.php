<?php

namespace App\Http\Controllers;

use App\Models\MsCategory;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class TransactionController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if (request()->isMethod('get')) {
            return view('pages.add-data-transaction');
        }


        $this->validation();
        $this->saveData('create');
        return redirect()->route('landing-page');
    }

    public function list()
    {
        $filters = [];
        $transaction_details = TransactionDetail::query();
        $transaction_details->with(['transaction', 'category']);

        if ($this->request->has('date-start') && $this->request->input('date-start') != null) {
            $filters['date-start'] = $this->request->input('date-start');
            $transaction_details->whereHas('transaction', function ($query) use ($filters) {
                $query->whereDate('date_paid', '>=', $filters['date-start']);
            });
        }
        if ($this->request->has('date-end') && $this->request->input('date-end') != null) {
            $filters['date-end'] = $this->request->input('date-end');
            $transaction_details->whereHas('transaction', function ($query) use ($filters) {
                $query->whereDate('date_paid', '<=', $filters['date-end']);
            });
        }
        if ($this->request->has('category') && $this->request->input('category') != null || $this->request->input('category') != '') {
            $filters['category'] = $this->request->input('category');
            $transaction_details->where('transaction_category_id', $filters['category']);
        }
        if ($this->request->has('search') && $this->request->input('search') != null || $this->request->input('search') != '') {
            $filters['search'] = $this->request->input('search');
            $transaction_details->whereHas('transaction', function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('code', 'like', '%' . $filters['search'] . '%');
            });
        }

        $transaction_details = $transaction_details->paginate(10);

        return view('pages.list-data-transaction', compact('transaction_details', 'filters'));
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            $transaction = Transaction::with('details')->where('id', $this->request->query('id'))->first();
            $categories = MsCategory::all();
            return view('pages.edit-data-transaction', compact('transaction', 'categories'));
        }

        $this->validation();
        $this->saveData('edit');
        return redirect()->route('landing-page');
    }

    public function delete($transaction_id)
    {
        DB::beginTransaction();
        try {
            TransactionDetail::where('transaction_id', $transaction_id)->delete();
            $count = TransactionDetail::where('transaction_id', $transaction_id)->count();
            if ($count == 0) {
                Transaction::where('id', $transaction_id)->delete();
            }

            DB::commit();
            return redirect()->route('list-data-transaction')->with('success', 'Data transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }

    private function validation()
    {
        $rules = [
            'description' => 'nullable|string|max:255',
            'code' => 'required|string|max:100',
            'rate_euro' => 'required|numeric',
            'transaction_date' => 'required|date',
            'categories' => 'required|array|min:1',
            'categories.*.category_id' => 'required|exists:ms_categories,id',
            'categories.*.name' => 'nullable|string|max:255',
            'categories.*.amount' => 'required|numeric',
        ];

        $messages = [
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
            'code.required' => 'Kode transaksi wajib diisi.',
            'code.string' => 'Kode transaksi harus berupa teks.',
            'code.max' => 'Kode transaksi maksimal :max karakter.',
            'rate_euro.required' => 'Nilai tukar Euro wajib diisi.',
            'rate_euro.numeric' => 'Nilai tukar Euro harus berupa angka.',
            'transaction_date.required' => 'Tanggal transaksi wajib diisi.',
            'transaction_date.date' => 'Tanggal transaksi tidak valid.',
            'categories.required' => 'Kategori transaksi wajib diisi.',
            'categories.array' => 'Kategori transaksi tidak valid.',
            'categories.min' => 'Minimal :min kategori transaksi harus diisi.',
            'categories.*.category_id.required' => 'Kategori wajib dipilih.',
            'categories.*.category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'categories.*.name.string' => 'Nama kategori harus berupa teks.',
            'categories.*.name.max' => 'Nama kategori maksimal :max karakter.',
            'categories.*.amount.required' => 'Jumlah untuk kategori ini wajib diisi.',
            'categories.*.amount.numeric' => 'Jumlah untuk kategori ini harus berupa angka.',
        ];

        $this->request->validate($rules, $messages);
    }

    private function saveData($status)
    {
        DB::beginTransaction();
        try {
            $transactionData = [
                'description' => $this->request->input('description'),
                'code' => $this->request->input('code'),
                'rate_euro' => $this->request->input('rate_euro'),
                'date_paid' => $this->request->input('transaction_date'),
            ];

            if ($status === 'edit') {
                $transactionData['created_at'] = now();
                $transaction = Transaction::where('id', $this->request->input('id'))->update($transactionData);
            } else {
                $transactionData['created_at'] = now();
                $transaction = Transaction::create($transactionData);

                $categories = $this->request->input('category');
                foreach ($categories as $key => $category_id) {
                    $names = collect($this->request->input('transaction_name')[$key]);
                    $amounts = collect($this->request->input('amount')[$key]);
                    $zipped = $names->zip($amounts);

                    $finalRecords = $zipped->map(function ($item) use ($transaction, $category_id) {
                        return [
                            'transaction_category_id' => $category_id,
                            'transaction_id' => $transaction->id,
                            'name' => $item[0],
                            'value_idr' => $item[1],
                            'created_at' => now(),
                        ];
                    })->toArray();
                    TransactionDetail::insert($finalRecords);
                }
            }

            DB::commit();
            return redirect()->route('landing-page')->with('success', 'Data transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }
}
