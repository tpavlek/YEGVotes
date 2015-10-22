<div class="person-details">
    <div class="council-member-img {{ $council_member->getShortWard() }}"></div>
    <h3>{{ $council_member->name }} <small>{{ $council_member->getWard() }}</small></h3>
    @if (isset($link) and $link)
        <a href="{{ URL::route('councillor.show', (string)$council_member) }}" class="button">
            <i class="fa fa-eye"></i> View
        </a>
    @endif
</div>
