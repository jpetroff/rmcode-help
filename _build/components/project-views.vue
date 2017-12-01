<template>
	<div class="custom-widget-container">
		<input type="range" id="project-views-range"
			   v-on:input="setValue($event.currentTarget.value)"
			   v-bind:value="this.value" class="additional-pvs" min="0" max="39" step="1"
			   v-on:mousedown="hasDrag"
			   v-on:mouseup="hasDrag"
		>
		<div class="montly-limit-section floating-section">
			<div class="floating-section__amount"
				 v-bind:style="sliderPos"
			>
				<span class="amount__prefix">+</span>
				<span class="amount__number" ref="variableViewsBlock">{{views}}</span>
				<span class="amount__description">project views<br/>per month</span>
			</div>
		</div>
		<div class="plan-description-section centered-section">
			<div class="centered-section__header">
				<div class="billing-switcher control-wrapper">
					<span v-on:click.prevent="toggleSwitcher($event.currentTarget.dataset.type)"
						  class="billing-switcher__control billing-switcher__monthly" data-type="month"
						  v-bind:class="[ this.price.selected == 'month' ? 'selected' : '']"
					>
						monthly billing
					</span>
					<span v-on:click.prevent="toggleSwitcher($event.currentTarget.dataset.type)"
						  class="billing-switcher__control billing-switcher__annually" data-type="year"
						  v-bind:class="[ this.price.selected == 'year' ? 'selected' : '']"
					>
						annual billing
						<span class="save-shield">Save 20%</span>
					</span>
				</div>
			</div>
			<div class="centered-section__amount column__right unit-price">
				<span class="amount__number unit-price-month" v-show="price.selected == 'month'">${{price.month}}</span>
				<span class="amount__number unit-price-year" v-show="price.selected == 'year'">${{price.year}}</span>
				<span class="amount__addition">
					<span class="hanging-element">+</span>
					current<br/>
					plan price
				</span>
			</div>
		</div>
	</div>
</template>

<script>
w.components['project-views'] = {
	template: '<%= template %>',
	data: function () {
		return {
			value: 0,
			views: '10,000',
			price: {
				month: '11',
				year: '105',
				selected: 'month'
			},
			sliderPos: {
				left: '-105px'
			},
			sliderStepW: (450 / 40)
		}
	},
	methods: {
		setValue: function(step) {
			this.value = step;
			
			var updatePricing = this.calcViewsBilling(step);
			this.views = updatePricing[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			this.price.month = updatePricing[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			this.price.year = updatePricing[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			
			this.$nextTick(function() {
				this.sliderPos.left = Math.floor(this.sliderStepW * step - this.$refs.variableViewsBlock.clientWidth + 25 - (11 * step / 40)) + 'px' ;
			});
		},
		calcViewsBilling: function(step) {
			var _step = step;
			var views = 10000;
			var unitPrice = 11;
			if(_step <= 19) {
				views += _step*10000
			} else if(_step >= 20 && _step <= 25) {
				views += 19*10000 + (_step - 19) * 50000
				unitPrice = 10
			} else if(_step >= 26) {
				views += 19*10000 + 6*50000 + (_step - 25)*100000
				unitPrice = 9
			}

			var units = views/10000

			return [views, units*unitPrice, Math.floor(units*unitPrice*12*0.8)]
		},
		toggleSwitcher: function(type) {
			this.price.selected = type;
		},
		hasDrag: function() {
			console.log('!');
		}
	},
	
}
</script>