<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::capture());

$project = \App\Models\Project::first();
if (!$project) {
    $project = new \App\Models\Project();
    $project->title = "O'Reilly & \"Quotes\"";
    $project->offerings = ["Quote \"1\"", "Quote '2'"];
}

$company = \App\Models\Company::first();

$html = <<<HTML
<div x-data="projectForm({
    title: {{ json_encode(\$project->title) }},
    offerings: {{ json_encode(\$project->offerings) }}
})">
HTML;

echo \Illuminate\Support\Facades\Blade::render($html, ['project' => $project]);
