<?php

return [
    'required' => ':attribute is verplicht.',
    'string' => ':attribute moet tekst zijn.',
    'integer' => ':attribute moet een geheel getal zijn.',
    'decimal' => ':attribute moet een geldig bedrag zijn met :decimal decimalen.',
    'max' => [
        'string' => ':attribute mag maximaal :max tekens bevatten.',
        'numeric' => ':attribute mag niet groter zijn dan :max.',
    ],
    'min' => [
        'string' => ':attribute moet minimaal :min tekens bevatten.',
        'numeric' => ':attribute moet minimaal :min zijn.',
    ],
    'unique' => ':attribute bestaat al.',

    'custom' => [
        'plate' => [
            'unique' => 'Voor dit kenteken bestaat al een aanbod.',
        ],
    ],

    'attributes' => [
        'name' => 'naam',
        'email' => 'e-mailadres',
        'password' => 'wachtwoord',
        'plate' => 'kenteken',
        'brand' => 'merk',
        'model' => 'model',
        'price' => 'vraagprijs',
        'mileage' => 'kilometerstand',
        'seats' => 'zitplaatsen',
        'doors' => 'aantal deuren',
        'weight' => 'massa rijklaar',
        'production_year' => 'jaar van productie',
        'color' => 'kleur',
    ],
];
