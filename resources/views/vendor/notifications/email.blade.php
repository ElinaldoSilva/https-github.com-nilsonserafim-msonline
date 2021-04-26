@component('mail::message')

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Opa!')
@else
# @lang('Olá,')
@endif
@endif

{{-- Intro Lines --}}
# @lang('Clique no botão abaixo para verificar o seu endereço de e-mail.')
<br>

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset


# @lang('Se você não criou uma conta, nenhuma ação adicional é necessária.')<br><br>Atenciosamente,<br>Cemitério e Crematório São Francisco de Paula


{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Se você estiver tendo problemas ao clicar no botão \":actionText\", copie e cole a URL abaixo\n".
    'em seu navegador:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
