<form method="POST" action="{{ route('admin.societes.actionsAVenir') }}">
    @csrf
    <table class="min-w-full border rounded-xl overflow-hidden shadow mt-4">
    <thead>
        <tr class="bg-[#152C54] text-white">
            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Date</th>
            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Motif</th>
            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Contact</th>
            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Type d'action</th>
            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Ajouté par</th>
            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Action à venir</th>
            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Évaluation</th>
            @push('styles')
<style>
    .star-rating-interactive {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
    }
    .star-rating-interactive .star {
        transition: color 0.2s;
        color: #222;
    }
    .star-rating-interactive .star.text-yellow-400 {
        color: #facc15 !important;
    }
    .star-rating-interactive .star.text-gray-400 {
        color: #222 !important;
    }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.star-rating-interactive').forEach(function(container) {
        const stars = Array.from(container.querySelectorAll('.star'));
        const input = container.querySelector('input[type="hidden"]');
        let currentValue = parseInt(input.value);

        function setStars(value) {
            stars.forEach((star, idx) => {
                if (idx < value) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                    star.style.color = '#facc15';
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                    star.style.color = '';
                }
            });
        }

        setStars(currentValue);

        stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', function() {
                setStars(idx + 1);
            });
            star.addEventListener('mouseleave', function() {
                setStars(currentValue);
            });
            star.addEventListener('click', function() {
                currentValue = idx + 1;
                input.value = currentValue;
                setStars(currentValue);
            });
        });
    });
});
</script>
@endpush
        </tr>
    </thead>
    <tbody id="actionsTableBody">
        @foreach($actions as $action)
            @if($action->contact_type && $action->contactable)
            <tr>

                <td class="px-4 py-2 text-[#152C54]">{{ $action->date_action ? \Carbon\Carbon::parse($action->date_action)->format('d/m/Y') : '' }}</td>
                <td class="px-4 py-2 text-[#152C54]">{{ $action->motif }}</td>
                <td class="px-4 py-2 text-[#152C54] font-medium">
                    {{ $action->contactable->email }}
                    
                </td>
                <td class="px-4 py-2 text-[#152C54]">{{ $action->commentaire }}</td>
                <td class="px-4 py-2 text-[#152C54]">{{ $action->user ? $action->user->name : '-' }}</td>
                <td class="px-4 py-2 text-[#152C54]">
                  <textarea name="action_a_venir[{{ $action->id }}]" rows="1" class="rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" style="width: 10rem; min-width: 80px; max-width: 140px;">{{ $action->action_a_venir ?? '' }}</textarea>
                </td>
                <td class="px-4 py-2 text-[#152C54]">
                  <div class="star-rating-interactive" data-action-id="{{ $action->id }}">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star inline-block cursor-pointer text-xl text-gray-300"
      data-star="{{ $i }}"
      style="font-size: 1.1em;"
>
    &#9733;
</span>
                    @endfor
                    <input type="hidden" name="evaluation[{{ $action->id }}]" value="{{ $action->evaluation ?? 0 }}">
                  </div>
                </td>
                
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
    <button type="submit" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors mt-2">Enregistrer</button>
</form>
