{{-- botão de exclusão com confirmação: o formulário só é enviado se o usuário confirmar --}}
<form action="{{ $acao }}" method="POST" class="d-inline" onsubmit="return confirm(@js($mensagem))">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger">{{ $texto ?? 'Excluir' }}</button>
</form>
