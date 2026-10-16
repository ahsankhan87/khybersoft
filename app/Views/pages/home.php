<?php
/**
 * Legacy alias — the homepage now lives in front/home/index.
 * Keeps old `pages/home` references working by forwarding.
 */
return view('front/home/index', $data ?? []);
