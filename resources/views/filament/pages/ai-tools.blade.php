<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-2">
        <x-filament::section>
            <x-slot name="heading">Content generator</x-slot>
            <x-slot name="description">Draft blog posts, service copy, or homeowner emails for Northclad.</x-slot>
            <form wire:submit="generate" class="space-y-4">
                {{ $this->generatorForm }}
                <x-filament::button type="submit">Generate</x-filament::button>
            </form>
            @if ($generatorResult)
                <div class="mt-4 whitespace-pre-wrap rounded-xl bg-gray-50 p-4 text-sm dark:bg-gray-900">{{ $generatorResult }}</div>
            @endif
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Automation suggestions</x-slot>
            <x-slot name="description">ERP ideas for jobs, inventory, invoices, and scheduling.</x-slot>
            <x-filament::button wire:click="suggestAutomations" color="success">Suggest automations</x-filament::button>
            @if ($automationResult)
                <div class="mt-4 whitespace-pre-wrap rounded-xl bg-gray-50 p-4 text-sm dark:bg-gray-900">{{ $automationResult }}</div>
            @endif
        </x-filament::section>

        <x-filament::section class="lg:col-span-2">
            <x-slot name="heading">Troubleshooting assistant</x-slot>
            <x-slot name="description">Diagnose moisture, install, or admin workflow issues.</x-slot>
            <form wire:submit="runTroubleshoot" class="space-y-4">
                {{ $this->troubleshootForm }}
                <x-filament::button type="submit" color="warning">Diagnose</x-filament::button>
            </form>
            @if ($troubleshootResult)
                <div class="mt-4 whitespace-pre-wrap rounded-xl bg-gray-50 p-4 text-sm dark:bg-gray-900">{{ $troubleshootResult }}</div>
            @endif
        </x-filament::section>
    </div>
</x-filament-panels::page>
