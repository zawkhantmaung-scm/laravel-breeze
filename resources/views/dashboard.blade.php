<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Stripe: Recommended integrations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        
                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                            <a href="{{ route('payment.link.plan') }}">
                                <div class="grid grid-cols-2 items-center">
                                    <div class="ml-6">
                                        <img src="{{ asset('no-code.png') }}" alt="no-code">
                                    </div>
                                    <div class="ml-6">
                                        <div class="text-lg font-semibold"><p class="text-gray-900 dark:text-white">Stripe Payment Links</p></div>
                                        <div class="mt-4 text-gray-600 dark:text-gray-400 text-sm">
                                            Embed or share a link to a Stripe payment page to accept payments without a website.
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                            <a href="{{ route('element.plan') }}">
                                <div class="grid grid-cols-2 items-center">
                                    <div class="ml-6">
                                        <img src="{{ asset('customize.png') }}" alt="customize">
                                    </div>
                                    <div class="ml-6">
                                        <div class="text-lg font-semibold"><p class="text-gray-900 dark:text-white">Stripe Elements</p></div>
                                        <div class="mt-4 text-gray-600 dark:text-gray-400 text-sm">
                                            Integrate customizable UI components into your website or mobile app to collect payment information from customers.
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
