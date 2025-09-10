<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Sample multiple choice questions
        Question::create([
            'question' => 'Wat is de hoofdstad van Nederland?',
            'type' => 'multiple_choice',
            'options' => ['Amsterdam', 'Den Haag', 'Rotterdam', 'Utrecht'],
            'answer' => 'Amsterdam',
        ]);

        Question::create([
            'question' => 'Hoeveel benen heeft een spin?',
            'type' => 'multiple_choice',
            'options' => ['6', '8', '10', '12'],
            'answer' => '8',
        ]);

        Question::create([
            'question' => 'Welke programmeeртaal wordt vaak gebruikt voor web ontwikkeling?',
            'type' => 'multiple_choice',
            'options' => ['Python', 'JavaScript', 'C++', 'Java'],
            'answer' => 'JavaScript',
        ]);

        // Sample open questions
        Question::create([
            'question' => 'Wat betekent de afkorting "HTML"?',
            'type' => 'open',
            'options' => null,
            'answer' => 'HyperText Markup Language',
        ]);

        Question::create([
            'question' => 'Noem drie primaire kleuren.',
            'type' => 'open',
            'options' => null,
            'answer' => 'Rood, geel, blauw',
        ]);

        Question::create([
            'question' => 'Wat is 15 + 27?',
            'type' => 'open',
            'options' => null,
            'answer' => '42',
        ]);

        // More complex questions
        Question::create([
            'question' => 'Welk van de volgende is GEEN object-georiënteerd programmeerprincipe?',
            'type' => 'multiple_choice',
            'options' => ['Encapsulatie', 'Inheritance', 'Polymorfisme', 'Compilatie'],
            'answer' => 'Compilatie',
        ]);

        Question::create([
            'question' => 'Wat is de output van deze PHP code: echo 5 + "3";?',
            'type' => 'open',
            'options' => null,
            'answer' => '8',
        ]);
    }
}
