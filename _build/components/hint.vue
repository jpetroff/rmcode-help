<template>
	<div class="def-hint-box" v-bind:class="[ show ? 'show' : '', landed ? 'def-hint-box_transitions' : '' ]" v-bind:style="{height:this.elHeight}">
		<div class="def-hint-box__toggle" v-on:click.prevent="toggle()" ref="toggleButton">
			{{header}}
			<i class="toggle-icon"><svg width="10px" height="15px" viewBox="0 0 10 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g id="close" stroke="#BEBEBE" stroke-width="1" stroke-linecap="round">
					<path d="M1,1 L5,14"></path>
					<path d="M9,1 L5,14"></path>
				</g>
			</svg></i>
		</div>
		<div class="def-hint-box__content" ref="boxContent">
			<slot></slot>
		</div>
	</div>
</template>

<script>
w.components['hint'] = {
	template: '<%= template %>',
	props: ['header'],
	data: function() {
		return { show: false, height: 0, collapsedHeight: 0, fullHeight: 0, elHeight: 0, landed: false }
	},
	mounted: function() {
		this.collapsedHeight = w.utils.outerHeight(this.$refs.toggleButton); // 2px border
		this.fullHeight = this.collapsedHeight + w.utils.outerHeight(this.$refs.boxContent);
		this.elHeight = this.show ? this.fullHeight : this.collapsedHeight;

		this.$el.addEventListener(w.utils.transitionName, _.bind(function(ev) {
			if(this.$el === ev.target) {
				this.$parent.$emit('recalcAnchorNav');
			}
		}, this));

		// prevent ontransitionend from firing at mount
		w.utils.updateDOM(function() {this.landed = true;}, this);
	},
	methods: {
		toggle: function() {
			this.show = !this.show;
			this.elHeight = this.show ? this.fullHeight : this.collapsedHeight;
		}
	}
}
</script>