@component('mail::message')
    # Ingredient Threshold Reached

    Hello Dear Merchant,

    This is to inform you that the stock of the ingredient {{ $ingredient->name }} has reached the threshold level of {{ $ingredient->threshold }}%
    and its current stock is {{ $ingredient->stock }} units.

    Please take necessary actions to refill the stock of this ingredient.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
