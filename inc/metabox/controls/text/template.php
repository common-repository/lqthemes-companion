<div class="hoocompanion-mb-desc">
	<# if ( data.label ) { #>
		<span class="butterbean-label">{{ data.label }}</span>
	<# } #>

	<# if ( data.description ) { #>
		<span class="butterbean-description">{{{ data.description }}}</span>
	<# } #>
</div>

<div class="hoocompanion-mb-field">
	<input type="text" value="{{ data.value }}" {{{ data.attr }}} />
</div>