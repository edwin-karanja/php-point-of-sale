<template>
    <div class="btn-group">
        <a class="btn btn-default btn-success btn-rounded calendar-picker"
           data-toggle="collapse"
           aria-expand="true"
        >
            <i class="fa fa-calendar"></i>
            <span class="date-range-label">{{ dateRange }}</span>
            <span class="caret"></span>
        </a>
    </div>
</template>

<script type="text/babel">
    import eventHub from '../../events.js';
    import moment from 'moment';
    import daterangepicker from '../../daterangepicker.js';

    export default {
        props: {
            showRanges: {
                type: Boolean,
                default: false
            },

            startDate: {
                default: function () {
                    return moment().subtract(30, 'days')
                }
            },

            endDate: {
                default: function () {
                    return moment()
                }
            },

            timePicker: {
                type: Boolean,
                default: false
            },

            singleDatePicker: {
                type: Boolean,
                default: false
            },

            minDate: {
                default: false
            },

            opens: {
                default: 'right'
            },

            maxDate: {
                default: false
            },

            autoApply: {
                default: false
            },

            for: {
                default: 'default'
            }
        },

        data () {
            return {
                start: this.startDate,
                end: this.endDate
            };
        },

        methods: {
            onDateChange (start, end) {
                this.start = start;
                this.end = end;
            }
        },

        computed: {
            dateRange () {
                var start = moment(this.start);
                var end = moment(this.end);
                var today = moment();

                if (start.format('LL') === end.format('LL') && today.format('LL') === start.format('LL')) {
                    return 'Today';
                } else if (start.format('MM-DD-YYYY') === end.format('MM-DD-YYYY')) {
                    return start.format('LL');
                }

                return this.start.format('LL') + ' - ' + this.end.format('LL');
            }
        },

        mounted () {
            var vm = this;

            if (this.singleDatePicker) {
                this.start = moment();
                this.end = moment();
            }

            this.$nextTick( function () {
                var options = {
                    opens: this.opens,
                    startDate: this.start,
                    endDate: this.end,
                    autoApply: this.autoApply,
                    alwaysShowCalendars: true
                };

                if (this.minDate) {
                    options.minDate = this.minDate;
                }
                if (this.maxDate) {
                    options.maxDate = this.maxDate;
                }
                if (this.timePicker) {
                    options.timePicker = true;
                    timePickerIncrement: 30;
                }
                if (this.singleDatePicker) {
                    options.singleDatePicker = true;
                    options.showDropdowns = true;
                }
                eventHub.$emit(this.for + '.apply', this.start, this.end)

                if (this.showRanges) {
                    options.ranges = {
                        Today: [moment(), moment()],
                        Yesterday: [
                            moment().subtract(1, 'days'),
                            moment().subtract(1, 'days')
                        ],
                        'Last 7 Days': [
                            moment().subtract(6, 'days'),
                            moment()
                        ],
                        'Last 30 Days': [
                            moment().subtract(30, 'days'),
                            moment()
                        ],
                        'This Month': [
                            moment().startOf('month'),
                            moment().endOf('month')
                        ],
                        'Last Month': [
                            moment().subtract(1, 'month').startOf('month'),
                            moment().subtract(1, 'month').endOf('month')
                        ]
                    };
                }

                window.$(this.$el)
                        .daterangepicker(options)
                        .on('apply.daterangepicker', function (e, picker) {
                                eventHub.$emit(vm.for + '.apply', picker.startDate, picker.endDate)
                                vm.start = picker.startDate
                                vm.end = picker.endDate
                            })
            })
        }
    }
</script>


<style scoped>
    .btn-group > a {
        color: black;
    }
</style>
