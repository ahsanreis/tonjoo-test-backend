@extends('layouts.app')
@section('title', 'List Data Transaksi')
@section('content')
<div class="button-filters">
     <a href="{{ route('data-transaction') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-green-700 shadow-lg transition duration-150 mb-4">
          Tambah Data Transaksi
     </a>
     <form action="{{ route('list-data-transaction') }}" method="get" class="filters inline-flex justify-between items-center space-x-4 mt-4 min-w-full">
          <a href="javascript:void(0);" id="reset-filter" class="bg-red-600 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-red-700 shadow-lg transition duration-150">Reset</a>
          <input type="date" id="filter-date-start" class="p-2 border border-gray-300 rounded-md">
          <p>to</p>
          <input type="date" id="filter-date-end" class="p-2 border border-gray-300 rounded-md">
          <select name="category" id="category" class="border border-gray-300 rounded-md p-2">
               <option value="">All Categories</option>
               <option value="1">Income</option>
               <option value="2">Expense</option>
          </select>
          <input type="text" class="search border border-gray-600 rounded-md p-2" placeholder="Search..." name="search">
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-lg font-semibold hover:bg-blue-700 shadow-lg transition duration-150">Apply Filter</button>
     </form>
</div>
<div class="overflow-x-auto mt-4">
     <table class="min-w-full border-collapse border border-gray-300">
          <thead>
               <tr>
                    <th class="border px-4 py-2 bg-gray-200">No</th>
                    <th class="border px-4 py-2 bg-gray-200">Deskripsi</th>
                    <th class="border px-4 py-2 bg-gray-200">Code</th>
                    <th class="border px-4 py-2 bg-gray-200">Rate Euro</th>
                    <th class="border px-4 py-2 bg-gray-200">Date Paid</th>
                    <th class="border px-4 py-2 bg-gray-200">Kategori</th>
                    <th class="border px-4 py-2 bg-gray-200">Nama Transaksi</th>
                    <th class="border px-4 py-2 bg-gray-200">Nominal</th>
                    <th class="border px-4 py-2 bg-gray-200">Actions</th>
               </tr>
          </thead>
          <tbody>
               @foreach($transaction_details as $key => $transaction_detail)
               <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $transaction_detail->transaction->description }}</td>
                    <td class="border px-4 py-2">{{ $transaction_detail->transaction->code }}</td>
                    <td class="border px-4 py-2">{{ $transaction_detail->transaction->rate_euro }}</td>
                    <td class="border px-4 py-2">{{ $transaction_detail->transaction->date_paid }}</td>
                    <td class="border px-4 py-2">{{ $transaction_detail->category->name }}</td>
                    <td class="border px-4 py-2">{{ $transaction_detail->name }}</td>
                    <td class="border px-4 py-2">{{ $transaction_detail->value_idr }}</td>
                    <td class="border px-4 py-2">
                         <a href="{{ route('edit-data-transaction', ['id' => $transaction_detail->transaction->id]) }}" class="text-blue-600 hover:underline">Edit</a>
                         |
                         <form action="#" method="POST" class="inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                         </form>
                    </td>
               </tr>
               @endforeach
          </tbody>
     </table>
     <div class="mt-2">
          {{ $transaction_details->links() }}
     </div>
</div>
@endsection
@pushOnce('scripts')
<script>
     // Javascript to handle filtering and searching (basic example)
     document.addEventListener('DOMContentLoaded', () => {
          const resetFilterBtn = document.getElementById('reset-filter');
          const filterDateStart = document.getElementById('filter-date-start');
          const filterDateEnd = document.getElementById('filter-date-end');
          const categorySelect = document.getElementById('category');
          const searchInput = document.querySelector('.search');

          resetFilterBtn.addEventListener('click', () => {
               filterDateStart.value = '';
               filterDateEnd.value = '';
               categorySelect.value = '';
               searchInput.value = '';
          });
     });
</script>
@endPushOnce