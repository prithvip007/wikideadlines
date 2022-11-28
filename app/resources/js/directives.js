Vue.directive('datetimepicker', {
    inserted: function (el, binding) {
        const { onlyDate, todayMidday, todayMorning, ...userOptions } = binding.value || {};

        const defaultOptions = {
            enableTime: true,
            altInput: true,
            altFormat: 'LLLL',
            dateFormat: 'YYYY-MM-DD\\\\THH:mm:ss.SSSZ',
            mobileDateTimeFormatStr: 'YYYY-MM-DD\\\\THH:mm:ss',
            mobileDateFormatStr: 'YYYY-MM-DD',
            mobileTimeFormatStr: 'HH:mm:ss',
            parseDate: function (dateString, format) {
                if (dateString instanceof Date) {
                    return moment(dateString);
                }

                return moment(dateString, format).toDate();
            },
            formatDate(dateObj, format) {
                return moment(dateObj).format(format);
            },
            onReady(selectedDates, inputValue, flatpickr) {
                if (options.autoFillDefaultTime === false) {
                    return;
                }

                if (!el.value) {
                    if (todayMidday) {
                        flatpickr.setDate(moment().set({hour: 12, minutes: 0, seconds: 0}).toDate(), true);
                    } else if (todayMorning) {
                        flatpickr.setDate(moment().set({hour: 8, minutes: 30, seconds: 0}).toDate(), true);
                    }
                } else {
                    flatpickr.setDate(moment(el.value, flatpickr.config.dateFormat).toDate());
                }
            }
        };

        const options = Object.assign({}, defaultOptions, userOptions);

        if (onlyDate) {
            options.enableTime = true;
            options.altFormat = 'dddd, MMMM D, YYYY';
        }

        $(el).flatpickr(options);

        if (el._flatpickr.timeContainer) {
            const button = document.createElement('span');

            button.innerText = 'Ok';
            button.classList.add('btn', 'btn-secondary', 'rounded-0', 'd-flex', 'justify-content-center', 'align-items-center');
            button.setAttribute('title', 'Click to close');
            button.setAttribute('tabindex', '-1');
            button.setAttribute('style', 'width: 10%;')

            button.addEventListener('click', () => {
                el._flatpickr.close();
            })

            el._flatpickr.timeContainer.append(button);
        }

        // If enableTime is true, flatpicker doesn't close calendar when date selected
        // SO, this is a fix
        // onChange hook doesn't work well because it gets triggered also on minutes/hours increment
        el._flatpickr.daysContainer.addEventListener('mousedown', (e) => {
            if (el._flatpickr.config.enableTime && el._flatpickr.days !== e.target) {
                el._flatpickr.close();
            }
        });
    },
    update(el, binding) {
        el._flatpickr.setDate(new Date(el.value));

        if (typeof binding.value.autoFillDefaultTime === 'boolean') {
            el._flatpickr.set('autoFillDefaultTime', binding.value.autoFillDefaultTime);
        }
    },
    unbind(el) {
        el._flatpickr.destroy();
        el._flatpickr = undefined;
    }
});

Vue.directive('localtime', {
    inserted: function (el, binding) {
        $(el).text(moment($(el).attr('datetime')).format(binding.value));
    }
});

function match(query, data) {
    const searchQuery = query.toLowerCase();

    const fields = {
        text: data.text ?? '',
        description: data.element?.dataset?.select2Description ?? '',
        keywords: data.element?.dataset?.select2Keywords ?? ''
    };

    for (const key of Object.keys(fields)) {
        const value = fields[key].toLowerCase();

        if (value.indexOf(searchQuery) > -1) {
            return {
                field: key,
                data
            };
        }
    }

    return null;
}

const initSelect2 = (el, binding) => {
    const options = Object.assign({
        width: '100%',
        theme: 'bootstrap4',
        templateResult(state) {
            if (state.isCreateTag) {
                return `Create new "${state.text}"`;
            }

            if (!state.element || !state.element.dataset.select2Description) {
                return state.text;
            }

            const option = $('<div>');

            option.text(state.text);
            option.append($('<div class="text-muted">').text(state.element.dataset.select2Description));

            return option;
        },
        matcher(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            const result = match(params.term, data);

            return result?.data || null;
        },
        sorter(data) {
            const query = $(el).data("select2").dropdown.$search.val();

            if (!query) {
                return data;
            }

            return data.sort((a, b) => {
                const matchA = match(query, a);
                const matchB = match(query, b);

                if (matchA && !matchB) {
                    return -1;
                } else if (matchB && !matchA) {
                    return 1;
                } else if (!matchB && !matchA) {
                    return 0;
                } else {
                    const fields = ['text', 'description', 'keywords'];

                    if (fields.indexOf(matchA.field) < fields.indexOf(matchB.field)) {
                        return -1;
                    } else if (fields.indexOf(matchA.field) > fields.indexOf(matchB.field)) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            });
        }
    }, binding.value || {});

    $(el).select2(options);

    // when using history API (back, forwards buttons) browsers do autocomplete form elements
    // for select elements in blink browsers no event fired
    setTimeout(() => $(el).trigger('change'));

    $(el).on('change', function (e) {
        if (el._changeDispatched) {
            el._changeDispatched = false;
            return;
        }

        el._changeDispatched = true;
        el.dispatchEvent(new Event('change'));
    });
}

Vue.directive('select2', {
    inserted: function (el, binding, vNode) {
        initSelect2(el, binding);
    },
    update: function(el) {
        el._changeDispatched = true;
        setTimeout(() => { $(el).trigger('change') });
    },
    unbind(el) {
        $(el).select2('destroy');
    }
});

Vue.directive('print', {
    inserted: function (el, binding) {
        if (binding.modifiers.hide && !window.print) {
            $(el).hide();
        }

        const prevTitle = document.title;
        const titleForPrinting = binding.value.title;

        window.addEventListener('beforeprint', function(event) {
            document.title  = titleForPrinting;
        });

        window.addEventListener('afterprint', function(event) {
            document.title = prevTitle;
        });


        $(el).on('click', () => {
            // fix for safari 
            document.title = titleForPrinting;

            // fix for safari 
            Promise.resolve().then(() => {
                window.print();
            })
        });
    }
});

Vue.directive('share', {
    inserted: function (el, binding) {
        const { value } = binding;

        if (!navigator.share) {
            const $el = $(el);
            $el.attr('style', `${$el.attr('style')};display: none !important`);

            return;
        }

        $(el).on('click', () => {
            navigator
                .share(value)
                .catch(console.error);
        });
    }
});
