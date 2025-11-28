{{-- Modal de Pagar --}}
<div class="modal fade" id="modalPagar{{ $lembrete->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-success text-white rounded-top-4">
                <h5 class="modal-title">Confirmar Pagamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="mb-3">
                    Tem certeza que deseja marcar <strong>{{ $lembrete->titulo }}</strong> como pago?
                </p>
                <form action="{{ route('lembretes.pagar', $lembrete->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success px-4">Sim, marcar como pago</button>
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Excluir --}}
<div class="modal fade" id="modalExcluir{{ $lembrete->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title">Excluir Lembrete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="mb-3">
                    Deseja realmente excluir <strong>{{ $lembrete->titulo }}</strong>?
                </p>
                <form action="{{ route('lembretes.destroy', $lembrete->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">Sim, excluir</button>
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
