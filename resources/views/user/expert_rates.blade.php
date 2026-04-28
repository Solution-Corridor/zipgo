<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>My Service Rates | Expert Dashboard</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Header with back button -->
    <div class="flex items-center justify-between px-4 py-3 bg-[#0F0F14] border-b border-gray-800">
      <a href="{{ url('/user-dashboard') }}" class="p-2 rounded-full bg-gray-800 text-gray-300 hover:bg-gray-700">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
      </a>
      <h1 class="text-lg font-bold text-white">My Service Rates</h1>
      <div class="w-8"></div>
    </div>

    <!-- Flash Messages -->
    <div class="px-4 mt-3">
      @if(session('success'))
      <div class="bg-green-900/40 border border-green-500 text-green-200 text-sm px-4 py-2 rounded-xl mb-3 flex items-center gap-2">
        <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
      </div>
      @endif
      @if($errors->any())
      <div class="bg-red-900/40 border border-red-500 text-red-200 text-sm px-4 py-2 rounded-xl mb-3 space-y-1">
        @foreach($errors->all() as $error)
        <p class="text-xs">⚠️ {{ $error }}</p>
        @endforeach
      </div>
      @endif
    </div>

    <!-- ADD RATE FORM -->
    <div class="px-4 mt-2 mb-5">
      <div class="card rounded-xl p-4 bg-gray-900/60 border border-gray-800">
        <div class="flex items-center gap-2 mb-3">
          <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-400"></i>
          <h3 class="font-semibold text-white text-base">Add New Service Rate</h3>
        </div>
        <form action="{{ route('expert.rates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
          @csrf
          <div>
            <label class="block text-gray-300 text-xs mb-1">Service Name *</label>
            <input type="text" name="service_name" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Electrical Repair, Plumbing, Web Dev">
          </div>
          <div>
            <label class="block text-gray-300 text-xs mb-1">Price (Rs.) *</label>
            <input type="number" step="0.01" name="rate" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm" placeholder="e.g., 1500">
          </div>
          <div>
            <label class="block text-gray-300 text-xs mb-1">Description (optional)</label>
            <textarea name="description" rows="2" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm" placeholder="What's included?"></textarea>
          </div>
          <div>
            <label class="block text-gray-300 text-xs mb-1">Service Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:ring-2 focus:ring-emerald-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:bg-emerald-600 file:text-white file:border-0">
            <p class="text-gray-500 text-[10px] mt-1">Max 2MB. JPG, PNG, GIF</p>
          </div>
          <button type="submit" class="w-full py-2.5 rounded-lg bg-gradient-to-r from-emerald-600 to-green-600 font-semibold text-white text-sm hover:brightness-110 transition flex items-center justify-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Add Service Rate
          </button>
        </form>
      </div>
    </div>

    <!-- RATES LIST -->
    <div class="px-4 mb-20">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-white font-semibold text-sm flex items-center gap-1"><i data-lucide="list" class="w-4 h-4"></i> Your Rate List</h3>
        <span class="text-gray-400 text-xs">{{ count($rates) }} service{{ count($rates) !== 1 ? 's' : '' }}</span>
      </div>

      @if($rates->count())
      <div class="space-y-3">
        @foreach($rates as $rate)
        <div class="bg-gray-900/70 rounded-xl border border-gray-800 p-3 transition hover:border-emerald-500/30">
          <!-- NEW: flex row with image on left, details in middle, buttons on right -->
          <div class="flex gap-3">
            <!-- Service Image (left) -->
            @if($rate->image)
            <img src="{{ asset('uploads/expert-rates/' . $rate->image) }}"
              alt="{{ $rate->service_name }}"
              class="w-16 h-16 rounded-lg object-cover bg-gray-800">
            @else
            <div class="w-16 h-16 rounded-lg bg-gray-800 flex items-center justify-center">
              <i data-lucide="image" class="w-6 h-6 text-gray-500"></i>
            </div>
            @endif

            <!-- Service Details (middle) -->
            <div class="flex-1">
              <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="font-bold text-white text-sm">{{ $rate->service_name }}</span>
                <span class="bg-emerald-500/20 text-emerald-300 text-[11px] px-2 py-0.5 rounded-full font-mono">Rs. {{ number_format($rate->rate, 0) }}</span>
              </div>
              @if($rate->description)
              <p class="text-gray-400 text-xs mt-1">{{ $rate->description }}</p>
              @endif
            </div>

            <!-- Action Buttons (right) -->
            <div class="flex gap-2 items-start">
              <button class="edit-rate-btn p-1.5 rounded-lg bg-gray-800 hover:bg-blue-600 transition text-gray-300"
                data-id="{{ $rate->id }}"
                data-name="{{ $rate->service_name }}"
                data-rate="{{ $rate->rate }}"
                data-desc="{{ $rate->description }}">
                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
              </button>
              <form action="{{ route('expert.rates.destroy', $rate->id) }}" method="POST" onsubmit="return confirm('Delete this rate?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 rounded-lg bg-gray-800 hover:bg-red-600 transition text-gray-300">
                  <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="text-center py-10 bg-gray-900/30 rounded-xl border border-dashed border-gray-700">
        <i data-lucide="file-text" class="w-10 h-10 text-gray-500 mx-auto mb-2"></i>
        <p class="text-gray-400 text-sm">No service rates added yet.</p>
        <p class="text-gray-500 text-xs mt-1">Use the form above to create your first rate.</p>
      </div>
      @endif
    </div>

    <!-- Edit Modal -->
    <dialog id="editRateModal" class="p-0 bg-transparent rounded-xl max-w-md w-full" style="width: 100%; max-width: 330px;">
      <div class="bg-gray-900 rounded-xl shadow-2xl border border-gray-700 p-5 text-white">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-bold flex items-center gap-2"><i data-lucide="edit-3" class="w-5 h-5 text-blue-400"></i> Edit Service Rate</h3>
          <button id="closeEditModalBtn" class="text-gray-400 hover:text-white text-2xl leading-5">&times;</button>
        </div>
        <form id="editRateForm" method="POST" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="rate_id" id="edit_rate_id">
          <div class="mb-3">
            <label class="block text-gray-300 text-xs mb-1">Service Name</label>
            <input type="text" name="service_name" id="edit_service_name" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">
          </div>
          <div class="mb-3">
            <label class="block text-gray-300 text-xs mb-1">Price (Rs.)</label>
            <input type="number" step="0.01" name="rate" id="edit_rate_value" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">
          </div>
          <div class="mb-4">
            <label class="block text-gray-300 text-xs mb-1">Description</label>
            <textarea name="description" id="edit_description" rows="2" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-gray-300 text-xs mb-1">Change Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">
            @if(isset($rate) && $rate->image)
            <p class="text-gray-500 text-[10px] mt-1">Current: {{ basename($rate->image) }}<br>Upload new to replace.</p>
            @endif
          </div>
          <div class="flex justify-end gap-3">
            <button type="button" id="cancelEditModal" class="px-4 py-2 bg-gray-700 rounded-lg text-sm">Cancel</button>
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-sm font-semibold">Update Rate</button>
          </div>
        </form>
      </div>
    </dialog>

    <!-- Bottom Navigation (as per your existing include) -->
    @include('user.includes.bottom_navigation')
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof lucide !== 'undefined') lucide.createIcons();

      const editModal = document.getElementById('editRateModal');
      const editForm = document.getElementById('editRateForm');

      window.openEditModal = function(id, name, rateVal, desc) {
        editForm.action = `/experts/update/rates/${id}`;
        document.getElementById('edit_rate_id').value = id;
        document.getElementById('edit_service_name').value = name;
        document.getElementById('edit_rate_value').value = rateVal;
        document.getElementById('edit_description').value = desc || '';
        editModal.showModal();
        if (window.lucide) lucide.createIcons();
      };

      document.querySelectorAll('.edit-rate-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.id;
          const name = btn.dataset.name;
          const rate = btn.dataset.rate;
          const desc = btn.dataset.desc;
          openEditModal(id, name, rate, desc);
        });
      });

      document.getElementById('closeEditModalBtn')?.addEventListener('click', () => editModal.close());
      document.getElementById('cancelEditModal')?.addEventListener('click', () => editModal.close());

      if (editModal) {
        editModal.addEventListener('click', (e) => {
          const rect = editModal.getBoundingClientRect();
          const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height && rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
          if (!isInDialog) editModal.close();
        });
      }
    });
  </script>
</body>

</html>