<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>All Transactions</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting + Add / Ref -->
    @include('user.includes.top_greetings')

    <!-- Main Content -->
    <div class="px-4 pt-2 pb-24"> <!-- pb-24 to prevent overlap with bottom nav -->

      <h2 class="text-xl font-bold text-white mb-5 text-center">
        All Transactions
      </h2>

      @if ($transactions->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-center">
          <div class="w-20 h-20 rounded-full bg-gray-800 flex items-center justify-center mb-4">
            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <p class="text-gray-400 text-lg">No transactions yet</p>
          <p class="text-gray-500 text-sm mt-2">Your activity will appear here</p>
        </div>

      @else

        <!-- This is the ONLY place where id="transactions-container" should exist -->
        <div class="space-y-3" id="transactions-container">
          @include('user.partials.transactions-list')
        </div>

        <!-- Load More section – also unique IDs only here -->
        <div class="mt-4 text-center" id="load-more-section"
             style="{{ $transactions->hasMorePages() ? '' : 'display: none;' }}">

          <button id="load-more-btn"
                  class="min-w-[180px] px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full font-medium transition disabled:opacity-50 disabled:cursor-not-allowed">
            Load More
          </button>

          <div id="loading" class="hidden mt-4 flex items-center justify-center gap-2 text-gray-400">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading...
          </div>

        </div>

      @endif

    </div>

    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div> <!-- end mobile container -->

  <script>
    let page = 2;
    let isLoading = false;

    const container   = document.getElementById('transactions-container');
    const loadBtn     = document.getElementById('load-more-btn');
    const loading     = document.getElementById('loading');
    const loadSection = document.getElementById('load-more-section');

    if (loadBtn) {
      loadBtn.addEventListener('click', async function() {
        if (isLoading) return;

        isLoading = true;
        loadBtn.disabled = true;
        loadBtn.textContent = 'Loading...';
        if (loading) loading.classList.remove('hidden');

        try {
          const response = await fetch(`{{ route('all_transactions') }}?page=${page}`, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'text/html'
            }
          });

          if (!response.ok) {
            throw new Error('Network response was not ok');
          }

          const html = await response.text();

          if (html.trim() === '') {
            // No more items
            loadSection.style.display = 'none';
          } else {
            // Append new transactions
            container.insertAdjacentHTML('beforeend', html);
            page++;

            // Optional: hide if the returned HTML looks empty / no real items
            if (!html.includes('transaction-item')) {
              loadSection.style.display = 'none';
            }

            loadBtn.disabled = false;
            loadBtn.textContent = 'Load More';
          }
        } catch (err) {
          console.error('Load more failed:', err);
          loadBtn.disabled = false;
          loadBtn.textContent = 'Load More';
          // You can show a small toast/error here if you want
        } finally {
          if (loading) loading.classList.add('hidden');
          isLoading = false;
        }
      });
    }
  </script>

</body>
</html>