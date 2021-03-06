<x-heptagon.app>
    <div class="container">
        <h2>{{ isset($pageHeading) ? $pageHeading : "" }}</h2>
    </div>
    <x-heptagon.validation-error />
    {{ $slot }}
</x-heptagon.app>
