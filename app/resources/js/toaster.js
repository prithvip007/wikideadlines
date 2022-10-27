class Toaster {
    add(title, body, delay) {
        delay = delay || 7000;

        const toast = $('<div class="toast rounded-m" role="alert" aria-live="assertive" aria-atomic="true">\n' +
            '            <div class="toast-body">\n' +
            '                Hello, world! This is a toast message.\n' +
            '            </div>\n' +
            '                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
            '                    <span aria-hidden="true">&times;</span>\n' +
            '                </button>\n' +
            '        </div>');

        toast.find('.mr-auto').html(title);
        toast.find('.toast-body').html(body);
        toast.data('delay', delay);

        toast.appendTo('#toasts-container');

        toast.toast('show');
    }

    error(title, body, delay) {
        delay = delay || 5000;

        const toast = $('<div class="toast toast-error" role="alert" aria-live="assertive" aria-atomic="true">\n' +
            '            <div class="toast-body">\n' +
            '                Hello, world! This is a toast message.\n' +
            '            </div>\n' +
            '                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
            '                    <span aria-hidden="true">&times;</span>\n' +
            '                </button>\n' +
            '        </div>');

        toast.find('.mr-auto').html(title);
        toast.find('.toast-body').html(body);
        toast.data('delay', delay);

        toast.appendTo('#toasts-container');

        toast.toast('show');
    }

    love(text) {
        const toast = $(' <div class="toast-love">\n' +
            '        <i class="fa fa-heart"></i>\n' +
            '        <span>THANK YOU!</span>\n' +
            '    </div>');

        toast.find('span').text(text);

        toast.appendTo('body');

        setTimeout(() => {
            toast.remove();
        }, 3000)
    }
}

module.exports = new Toaster();
