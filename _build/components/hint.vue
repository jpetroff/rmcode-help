<template>
	<div class="def-hint-box" v-bind:class="[ show ? 'show' : '']">
		<div class="def-hint-box__toggle" v-on:click.prevent="toggle()">{{header}}</div>
		<div class="def-hint-box__content">
			<slot></slot>
		</div>
	</div>
</template>

<script>
w.components['hint'] = {
	template: '<%= template %>',
	props: ['header'],
	data: function() {
		return { show: true }
	},
	methods: {
		toggle: function() {
			this.show = !this.show;
		}
	}
}
</script>