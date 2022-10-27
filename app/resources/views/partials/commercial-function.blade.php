@include('partials.picture-banner', [
    'imageSource' => '/images/lock.svg',
    'imageAlt' => 'credit card',
    'titleText' => 'This function is available only for users with subscription',
    'link' => route('pricing'),
    'linkText' => 'Buy now'
])
