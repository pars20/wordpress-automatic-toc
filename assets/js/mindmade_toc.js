jQuery(function($) {
    // Select the title element once and cache it.
    const $tocTitle = $('.mindmade_toc_list h2');

    $tocTitle.on('click', function() {
        const $this = $(this); // Cache the clicked element
        const $tocList = $this.next('ul'); // Find the next ul element, which is more direct

        // Toggle the class on the title
        $this.toggleClass('is-open');

        // Toggle the list with a slide effect
        $tocList.slideToggle();
    });
});