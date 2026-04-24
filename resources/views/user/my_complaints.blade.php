<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>My Complaints</title>
  <!-- Alpine.js for modal toggle (small & lightweight) -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-[#0A0A0F]" x-data="{ showForm: false }">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <!-- Main Content -->
    <div class="px-5 pt-6 pb-28">

      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">My Complaints</h2>
        <button @click="showForm = true"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-xl shadow-lg shadow-indigo-900/30 transition-all flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          New Complaint
        </button>
      </div>

      @include('includes.success')

      @if ($complaints->isEmpty())
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-16 text-center">
          <div class="w-20 h-20 rounded-full bg-gray-800 flex items-center justify-center mb-5">
            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4a2 2 0 00-2 2v3m-4-5H4"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-300 mb-3">No Complaints Yet</h3>
          <p class="text-gray-500 text-base max-w-[280px]">
            You haven't submitted any complaints.<br>Tap the button above to get support.
          </p>
        </div>
      @else
        <!-- Complaints List -->
        <div class="space-y-4">
@foreach ($complaints as $complaint)
  <div class="bg-gray-900/70 rounded-xl p-4 border border-gray-800/60">
    <div class="flex justify-between items-start mb-2">
      <h3 class="font-semibold text-white text-lg line-clamp-1">
        {{ $complaint->subject }}
      </h3>

      <span class="px-2.5 py-1 rounded-full text-xs font-medium
        {{ $complaint->status === 'pending'     ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : '' }}
        {{ $complaint->status === 'in_progress' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
        {{ $complaint->status === 'resolved'    ? 'bg-green-500/20 text-green-400 border border-green-500/30' : '' }}
        {{ $complaint->status === 'rejected'    ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
        {{ $complaint->status === 'not_valid'   ? 'bg-gray-500/20 text-gray-400 border border-gray-500/30' : '' }}">
        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
      </span>
    </div>

    <p class="text-gray-300 text-sm mb-3 line-clamp-3">
      {{ $complaint->detail }}
    </p>
    @if ($complaint->screenshot)
          <div class="mt-3">
            <a href="{{ asset($complaint->screenshot) }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1 text-sm text-indigo-400 hover:underline">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
              </svg>
              View Attachment
            </a>
          </div>
          @endif

    {{-- Admin Reply Section --}}
    @if ($complaint->admin_reply)
      <div class="mt-4 pt-3 border-t border-gray-700/70 bg-gray-800/40 rounded-lg p-3">
        <div class="flex items-center gap-2 mb-2">
          <span class="text-indigo-400 text-xs font-medium">Support Team Reply</span>
          @if ($complaint->resolved_at)
            <span class="text-gray-500 text-xs">• {{ $complaint->resolved_at->format('d M Y • h:i A') }}</span>
          @endif
        </div>
        <p class="text-gray-200 text-sm leading-relaxed">
          {{ $complaint->admin_reply }}
        </p>
        @if ($complaint->attachments)
          <div class="mt-3">
            <a href="{{ asset($complaint->attachments) }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1 text-sm text-indigo-400 hover:underline">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
              </svg>
              View Attachment
            </a>
          </div>
          @endif
      </div>
    @endif

    <div class="flex justify-between text-xs text-gray-500 mt-3">
      <span>{{ $complaint->created_at->format('d M Y • h:i A') }}</span>
      @if (!$complaint->admin_reply)
        <span class="text-indigo-400">Waiting for reply</span>
      @endif
    </div>
  </div>
@endforeach

          <!-- Pagination (if using paginate) -->
          <div class="mt-6">
            {{ $complaints->links('pagination::tailwind') }}
          </div>
        </div>
      @endif

    </div>

    <!-- New Complaint Modal / Form -->
    <div x-show="showForm"
         class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 px-5"
         @click.away="showForm = false"
         x-transition>
      <div class="bg-gray-900 rounded-2xl w-full max-w-md p-6 border border-gray-700/50 shadow-2xl"
           @click.stop>
        <div class="flex justify-between items-center mb-5">
          <h3 class="text-xl font-bold text-white">New Complaint</h3>
          <button @click="showForm = false" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
          @csrf

          <div>
            <label class="block text-gray-300 text-sm font-medium mb-2">Subject</label>
            <input type="text" name="subject" required
                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition"
                   placeholder="e.g. Payment delay" maxlength="120">
          </div>

<div>
  <label class="block text-gray-300 text-sm font-medium mb-2">Details</label>
  <textarea name="detail" rows="3" required
            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition resize-none"
            placeholder="Describe your issue in detail..."></textarea>
</div>

<!-- Screenshot Upload -->
<div id="upload-wrapper">
  <label class="text-sm text-gray-400 block mb-2">
    Upload Screenshot
  </label>

  <div id="upload-box"
       class="relative border-2 border-dashed border-gray-600 rounded-2xl p-3 text-center cursor-pointer
              bg-black/30 hover:border-emerald-500 hover:bg-emerald-500/5 transition-all duration-300">

      <input type="file"
             name="screenshot"
             id="screenshot"
             accept="image/*"
             class="absolute inset-0 opacity-0 cursor-pointer">

      <!-- Upload Icon -->
      <div id="upload-content" class="space-y-2">
          <div class="flex justify-center">
              <i data-lucide="upload-cloud" class="w-7 h-7 text-emerald-400"></i>
          </div>

          <p class="text-sm text-gray-300 font-medium">
              Click to upload
          </p>

          <p class="text-xs text-gray-500">
              PNG, JPG (Max 2MB)
          </p>
      </div>

      <!-- Image Preview -->
      <div id="image-preview" class="hidden relative">
          <img id="preview-img"
               class="mx-auto rounded-xl max-h-32 object-contain shadow-lg border border-gray-700">

          <button type="button"
                  onclick="removeImage()"
                  class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-500 text-white p-1.5 rounded-full shadow-lg transition">
              <i data-lucide="x" class="w-3 h-3"></i>
          </button>
      </div>
  </div>
</div>

          <button type="submit"
                  class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl shadow-lg transition-all">
            Submit Complaint
          </button>
        </form>
      </div>
    </div>

    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div>

  <script>
       // ── Image upload preview logic ──
    const input = document.getElementById('screenshot');
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadContent = document.getElementById('upload-content');
    const uploadBox = document.getElementById('upload-box');

    input.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          preview.classList.remove('hidden');
          uploadContent.classList.add('hidden');
        }
        reader.readAsDataURL(this.files[0]);
      }
    });

    function removeImage() {
      input.value = "";
      preview.classList.add('hidden');
      uploadContent.classList.remove('hidden');
    }

    uploadBox.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadBox.classList.add('border-emerald-500', 'bg-emerald-500/10');
    });

    uploadBox.addEventListener('dragleave', () => {
      uploadBox.classList.remove('border-emerald-500', 'bg-emerald-500/10');
    });

    uploadBox.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadBox.classList.remove('border-emerald-500', 'bg-emerald-500/10');
      if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
      }
    });
  </script>

</body>
</html>