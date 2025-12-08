@extends('layouts.app')
@section('title', 'Tambah Data Transaksi')
@section('content')
<form action="{{ route('data-transaction') }}" method="POST" class="space-y-6">
     @csrf
     <div class="flex justify-between gap-4">
          <div class="flex flex-col w-1/2">
               <label for="description" class="w-full font-medium text-gray-700">Deskripsi:</label>
               <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
          </div>
          <div class="w-1/2">
               <div class="flex">
                    <label for="code" class="w-1/4 font-medium text-gray-700">Code:</label>
                    <input type="number" id="code" name="code" class="w-3/4 p-2 border border-gray-300 rounded-md" required>
               </div>
               <div class="flex mt-4">
                    <label for="rate_euro" class="w-1/4 font-medium text-gray-700">Rate Euro:</label>
                    <input type="number" id="rate_euro" name="rate_euro" class="w-3/4 p-2 border border-gray-300 rounded-md" required>
               </div>
               <div class="flex mt-4">
                    <label for="date_paid" class="w-1/4 font-medium text-gray-700">Date Period:</label>
                    <input type="date" id="date_paid" name="date_paid" class="w-3/4 p-2 border border-gray-300 rounded-md" required>
               </div>
          </div>
     </div>
     <div class="repeater-area">
          <div class="flex justify-between items-center mb-4 mt-8">
               <p class="text-2xl font-bold">Data Transaksi</p>
               <button id="add-group-btn" type="button" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-blue-700 shadow-lg mb-6 transition duration-150">
                    Tambah Transaksi Baru
               </button>
          </div>
          @include('components.transactionRepeater')
     </div>
     <div class="text-right mt-6">
          <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-green-700 shadow-lg transition duration-150">
               Simpan
          </button>
          <a href="{{ route('landing-page') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg text-lg font-semibold hover:bg-red-700 shadow-lg transition duration-150">
               Batal
          </a>
     </div>
</form>
@endsection
@pushOnce('scripts')
<script>
     //! Javascript to handle entire repeat Transaction data
     document.addEventListener('DOMContentLoaded', () => {
          // Get Container of Repeater Component and Add Button
          const repeaterContainer = document.getElementById('repeater-container');
          const addGroupButton = document.getElementById('add-group-btn');

          // Set Which The One that will be Cloned
          const initialGroup = repeaterContainer.querySelector('.transaction-group');
          const groupTemplate = initialGroup.innerHTML;

          // Counter to maintain unique names (important for Laravel/backend)
          let groupIndex = 1; // Start at 1 since the initial group is 0

          // Function to attach all event listeners for 'Tambah Item' and 'Hapus'
          const attachGroupListeners = (groupElement, index) => {
               // Inner Row Repeater Logic
               const addRowBtn = groupElement.querySelector('.add-row-btn');
               const tableBody = groupElement.querySelector('.transaction-rows');
               const rowTemplate = tableBody.querySelector('.transaction-row-template').outerHTML;

               // Add Row Listener
               addRowBtn.addEventListener('click', () => {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = rowTemplate;

                    // Clean the template row before inserting
                    newRow.querySelector('input[type="text"]').value = '';
                    newRow.querySelector('input[type="number"]').value = '';

                    tableBody.appendChild(newRow);
                    // Re-attach remove listeners to all rows in this specific group
                    attachRemoveRowListeners(groupElement);
               });

               // Remove Row Logic
               const attachRemoveRowListeners = (group) => {
                    // Select only buttons within THIS specific group
                    const removeButtons = group.querySelectorAll('.remove-row-btn');
                    removeButtons.forEach(button => {
                         // Ensure the click event is not duplicated
                         button.onclick = null;
                         button.onclick = (e) => {
                              const rowToRemove = e.target.closest('tr');
                              // Prevent deleting the very last row
                              if (group.querySelectorAll('.transaction-rows tr').length > 1) {
                                   rowToRemove.remove();
                              } else {
                                   alert("Must have at least one transaction item in a group.");
                              }
                         };
                    });
               };

               // Remove Group Logic
               const removeGroupBtn = groupElement.querySelector('.remove-group-btn');
               removeGroupBtn.addEventListener('click', (e) => {
                    e.target.closest('.transaction-group').remove();
               });

               attachRemoveRowListeners(groupElement);
          };

          attachGroupListeners(initialGroup, 0);


          // Global Group Repeater Logic
          addGroupButton.addEventListener('click', () => {
               // Create the new group element
               const newGroup = document.createElement('div');
               newGroup.className = 'transaction-group border border-gray-300 rounded-lg p-4 bg-white shadow-md space-y-4';
               newGroup.innerHTML = groupTemplate;

               // 2. Update Group Title and Input Names (The crucial part)
               newGroup.querySelector('h3').textContent = `Grup #${groupIndex + 1}`; // Update title

               // Find all inputs/selects that need indexing
               newGroup.querySelectorAll('[name]').forEach(input => {
                    const originalName = input.name;
                    let newName;

                    // 1. Update the name for the category select
                    if (originalName.startsWith('category')) {
                         newName = originalName.replace('category[0]', `category[${groupIndex}]`);
                    }
                    // 2. Update the names for the table inputs
                    else if (originalName.includes('[0][]')) {
                         newName = originalName.replace('[0][]', `[${groupIndex}][]`);
                    } else {
                         // Skip other non-indexed inputs if any
                         return;
                    }

                    input.name = newName;
                    input.value = ''; // Clear the value of the cloned input
               });

               // 3. Attach listeners and append
               repeaterContainer.appendChild(newGroup);
               attachGroupListeners(newGroup, groupIndex);
               groupIndex++;

          });

     });
</script>
@endPushOnce