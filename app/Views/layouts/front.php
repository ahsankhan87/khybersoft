<?php
/**
 * Convenience alias for the front layout (some docs reference layouts/front).
 * Forwards everything to the canonical master layout.
 */
return view('layout/master', $data ?? []);
