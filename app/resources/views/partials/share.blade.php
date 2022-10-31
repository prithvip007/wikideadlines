<div class="share-buttons d-print-none">
    <a class="share-buttons__link share-buttons__link--fb"
       href="https://facebook.com/sharer/sharer.php?u={{ urlencode(route('home')) }}" target="_blank">
        <i class="fa fa-facebook"></i>
        <span class="share-buttons__link-caption">Share on FB</span>
    </a>
    <a class="share-buttons__link share-buttons__link--tweeter"
       href="https://twitter.com/intent/tweet?text={{ urlencode('WikiDeadlines ' . route('home')) }}"
       target="_blank">
        <i class="fa fa-twitter"></i>
        <span class="share-buttons__link-caption">Tweet</span>
    </a>
    <a class="share-buttons__link"
       href="mailto:?subject={{ rawurlencode('WikiDeadlines – Get court deadlines calculated for free for two full legal cases.') }}&body={{ rawurlencode(route('home')) }}">
        <i class="fa fa-envelope"></i>
        <span class="share-buttons__link-caption">Email</span>
    </a>
</div>


