<style>
    .modal-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000; /* Atur z-index sesuai kebutuhan */
        visibility: hidden;
    }

    .modal-content {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 20px;
        max-width: 600px;
        width: 100%;
    }

    .modal-container.show {
        visibility: visible;
    }
</style>

<div class="modal-container" id="modal-container">
    <div class="modal-content">
        <h2 class="text-2xl font-bold mb-4">{{ __('Search Results') }}</h2>
        <div id="search-results" class="text-gray-700"></div>
        <button id="close-modal" class="mt-4 px-4 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800">{{ __('Close') }}</button>
    </div>
</div>

<div class="flex justify-center mt-4">
    <form action="{{ url('/search') }}" method="GET" class="flex" id="search-form">
        <input type="text" name="no_ticket" placeholder="{{ __('Enter Ticket Number') }}" class="px-4 py-2 rounded-l-lg border border-gray-300">
        <button type="submit" class="px-4 py-2 bg-primary-700 text-white rounded-r-lg hover:bg-primary-800">{{ __('Search') }}</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const form = event.target;
        const query = form.no_ticket.value.trim();

        // Pengecekan apakah nomor tiket dimulai dengan 'RG' dan panjangnya sesuai
        if (!/^RG\d{10}$/.test(query)) {
            alert('Silakan masukkan nomor tiket lengkap yang valid, contoh: RG2408082011');
            return;
        }

        fetch(`/search?no_ticket=${query}`)
            .then(response => response.json())
            .then(data => {
                let results = '';
                if (data.length > 0) {
                    data.forEach(result => {
                        results += `
                            <div class="bg-white rounded-lg shadow-lg p-4 mb-4 w-full max-w-sm">
                                <p><strong>No Ticket:</strong> ${result.no_ticket}</p>
                                <p><strong>Title:</strong> ${result.title}</p>
                                <p><strong>Status:</strong> ${result.ticket_statuses_id}</p>
                                <p><strong>Description:</strong> ${result.description}</p>
                            </div>
                            <hr>
                        `;
                    });
                } else {
                    results = '<p>Data tidak ditemukan</p>';
                }
                document.getElementById('search-results').innerHTML = results;
                document.getElementById('modal-container').classList.add('show');
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('search-results').innerHTML = '<p>Terjadi kesalahan saat melakukan pencarian</p>';
                document.getElementById('modal-container').classList.add('show');
            });
    });

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('modal-container').classList.remove('show');
    });
});

</script>