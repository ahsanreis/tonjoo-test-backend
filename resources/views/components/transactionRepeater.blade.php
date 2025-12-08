<div id="repeater-container" class="space-y-6">
     <div class="transaction-group border border-gray-300 rounded-lg p-4 bg-white shadow-md space-y-4">
          <h3 class="text-xl font-bold border-b pb-2 mb-4 text-gray-700">Grup #1</h3>

          <div class="flex justify-between p-4 bg-gray-50 rounded-md">
               <label for="category-0" class="font-medium text-gray-700">Category</label>
               <select id="category-0" name="category[0]" class="p-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="1">Income</option>
                    <option value="2">Expense</option>
               </select>
          </div>

          <div class="flex flex-col md:flex-row items-start space-y-4 md:space-y-0 md:space-x-4">
               <table class="w-full border-collapse border border-gray-300">
                    <thead>
                         <tr>
                              <th class="border px-4 py-2 bg-gray-200">Nama Transaksi</th>
                              <th class="border px-4 py-2 bg-gray-200">Nominal</th>
                              <th class="border px-4 py-2 bg-gray-200">Aksi</th>
                         </tr>
                    </thead>
                    <tbody class="transaction-rows">
                         @include('components.dataTransactionRepeater')
                    </tbody>
               </table>

               <button type="button" class="add-row-btn bg-green-500 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-green-600 shadow-md transition duration-150 whitespace-nowrap">
                    Tambah Item
               </button>
          </div>

          <div class="text-right pt-4">
               <button type="button" class="remove-group-btn text-sm text-red-500 hover:text-red-700 font-semibold transition duration-150">
                    Hapus Group
               </button>
          </div>
     </div>
</div>