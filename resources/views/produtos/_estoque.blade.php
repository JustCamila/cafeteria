{{-- estoque com cor: vermelho quando acabou, amarelo quando está baixo --}}
@if ($estoque <= 0)
    <span class="badge text-bg-danger">Sem estoque</span>
@elseif ($estoque <= 5)
    <span class="badge text-bg-warning">{{ $estoque }} (baixo)</span>
@else
    <span class="badge text-bg-success">{{ $estoque }}</span>
@endif
