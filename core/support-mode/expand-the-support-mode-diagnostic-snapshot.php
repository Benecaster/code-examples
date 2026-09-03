<?php
// Include more debug-log history in the Support Mode diagnostic snapshot

add_filter(
    'benecaster_support_mode_log_limit',
    static fn() => 500
);
