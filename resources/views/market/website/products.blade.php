<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Products : Feature Desk">
<meta property="og:description" content="Feature Desk - Your trusted online marketplace...">

    @include('market.website.includes.header_links')
    <title>Products - Feature Desk</title>
    <meta name="description" content="Feature Desk - Your trusted online marketplace...">
    <meta name="keywords" content="Feature Desk, Feature Desk, buy products online...">

    <style>
        /* … your existing styles … */
        .load-more-wrapper {
            text-align: center;
            margin-top: 30px;
        }

        .btn-load-more {
            display: inline-block;
            padding: 12px 30px;
            font-size: 16px;
        }

        .spinner {
            display: none;
        }

        /* Breadcrumb Banner */
    </style>
</head>

<body style=" background-color: #FFFFFF;">
    @include('market.website.includes.navbar')


    <!-- Products Section -->
    <section class="container-fluid my-4">
        <div class="products-grid-sm" style="margin-top: 80px;">
            @foreach ($products as $p)
            @include('market.website.includes.product_card_small')
            @endforeach
        </div>
        <!-- Load more button -->
        <div class="load-more-wrapper" id="load-more-wrapper"
            style="{{ $hasMore ? '' : 'display:none;' }}">
            <button class="btn btn-danger btn-load-more" id="btn-load-more">
                Load More
            </button>
            <span class="spinner">Loading...</span>
        </div>
    </section>

    @include('market.website.includes.footer')
    @include('market.website.includes.footer_links')

    {{-- --------------------------------------------------- --}}
    {{-- AJAX Load-More Script                               --}}
    {{-- --------------------------------------------------- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('btn-load-more');
            const spinner = btn.nextElementSibling;
            const container = document.getElementById('products-container');
            const wrapper = document.getElementById('load-more-wrapper');

            let page = {
                {
                    $page
                }
            };

            btn.addEventListener('click', function() {
                btn.style.display = 'none';
                spinner.style.display = 'inline';

                fetch("{{ route('products.loadMore') }}?page=" + page, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        // Append new cards
                        container.insertAdjacentHTML('beforeend', data.html);

                        page = data.nextPage ?? page;

                        // Show / hide button
                        if (data.hasMore) {
                            btn.style.display = 'inline-block';
                        } else {
                            wrapper.style.display = 'none';
                        }
                    })
                    .catch(() => alert('Something went wrong.'))
                    .finally(() => spinner.style.display = 'none');
            });
        });
    </script>
</body>

</html>