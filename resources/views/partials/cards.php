<div id="misTarjetas" style="display: none; opacity: 0;" data-target-group="idForm">
    <!-- Title -->
    <header class="text-center mb-7">
        <h2 class="h4 mb-0">Mis Tarjetas</h2>
    </header>

    <table class="table table-bordered table-striped w-full text-center border-collapse">
        <thead>
            <tr>
                <th class="border-b py-2">Codigo</th>
                <th class="border-b py-2">Email</th>
                <th class="border-b py-2">Tarjeta</th>
                <th class="border-b py-2">Creacion</th>
                <th class="border-b py-2 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="card-list-simple"></tbody>
    </table>
</div>


<script>
    function loadCards() {
        axios.post('/api/card/list')
            .then(response => {
                const tableBody = document.getElementById('card-list-simple');
                tableBody.innerHTML = '';
                response.data.forEach(card => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td class="border-b py-2">${card.id}</td>
                    <td class="border-b py-2">${card.email}</td>
                    <td class="border-b py-2">${card.card_number}</td>
                    <td class="border-b py-2">${card.creation_date}</td>                
                    <td class="border-b py-2">
                    <div class="flex space-x-2 text-center">
                        <button class="bg-danger border-0 text-white px-2 py-1 rounded-lg remove-card-btn" data-card-id="${card.id}">
                            Eliminar
                        </button>
                    </div>
                    </td>
                `;
                    tableBody.appendChild(row);
                });

                document.querySelectorAll('.remove-card-btn').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const cardId = e.target.getAttribute('data-card-id');
                        removeCard(cardId);
                    });
                });
            })
            .catch(error => console.error(error));
    }

    function removeCard(cardId) {
        axios.delete(`/api/card/${cardId}`)
            .then(response => {
                alert('Tarjeta eliminada exitosamente');
                loadCards();
            })
            .catch(error => console.error(error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.u-sidebar');
        const misTarjetasLink = document.querySelector('[data-target="#misTarjetas"]');
        const sidebarContent = document.querySelector('#sidebarContent');
        const closeButton = sidebarContent.querySelector('.close');

        misTarjetasLink.addEventListener('click', function() {
            if (sidebar) {
                sidebar.style.width = '55.75rem';
            }
        });

        const resetSidebarWidth = function() {
            if (sidebar) {
                sidebar.style.width = '24.75rem';
            }
        };

        document.addEventListener('click', function(event) {
            const isClickInside = sidebarContent.contains(event.target) || misTarjetasLink.contains(event.target);
            if (!isClickInside) {
                resetSidebarWidth();
            }
        });

        if (closeButton) {
            closeButton.addEventListener('click', resetSidebarWidth);
        }
    });

    loadCards();
</script>