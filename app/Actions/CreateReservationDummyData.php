<?php

namespace App\Actions;

use App\Models\Guest;

class CreateReservationDummyData
{   

    const RSVP_QUESTIONS = [
        [
            'id' => 1,
            'question' => 'Are you attending?',
            'type' => 'options',
            'options' => ['Yes', 'No'],
            'multiple' => false,
            'optional' => false,
            'deletable' => false,
        ],
        [
            'id' => 2,
            'question' => 'Dietary Restrictions',
            'type' => 'options',
            'options' => ['Vegan', 'Vegetarian', 'Gluten-free', 'None'],
            'multiple' => false,
            'optional' => true,
            'default' => 'None',
            'deletable' => true,
        ],
        [
            'id' => 3,
            'question' => 'Additional Comments',
            'type' => 'text',
            'optional' => true,
            'deletable' => true,
        ],
    ];

    public static function for($page):void
    {
        $page->reservation()->create(
            [
                'rsvp_questions' => self::RSVP_QUESTIONS,
            ]
        );

        $group = $page->reservation->groups()->create([
            'name' => 'Dummy Group',
            'rsvp_code' => Guest::generateRsvpCode(), // Group can have a unique RSVP code.
        ]);

        $group->guests()->create([
            'name' => 'Dummy Guest',
            'email' => 'dummy@example.com',
            'phone' => '1234567890',
            'rsvp_code' => Guest::generateRsvpCode(),
            'rsvp_data' => json_encode([]),
            'is_attending' => false,
            'answered_at' => null,
            'invitation_sent_at' => null,
        ]);
    }
}
