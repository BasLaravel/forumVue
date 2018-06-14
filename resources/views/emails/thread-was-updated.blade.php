@component('mail::message')
# U heeft een nieuw bericht op uw rubriek van {{$reply->owner->name}}.

@component('mail::button', ['url' => url($path.'#reply-'.$reply->id)])
Naar bericht
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
