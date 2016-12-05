$(document).ready(function() {
	$(document).click(function(event){
		if ($(event.target).closest("#message").length) return;
		if ($(event.target).closest(".metro-select").length) return;
		$('.metro-select').removeClass('open');
		event.stopPropagation();
	});
	$(".metro-select").click(function() {
		$(this).toggleClass("open");
	});

	$(".b-metro-map").click(function(event) {
		event.stopPropagation();
	});
	$(".metro-clear").click(function() {
		$(".b-metro-map input").prop("checked", false);
		updateMetroMap();
	});
	$(".metro-close").click(function() {
		$(".metro-select").removeClass("open");
		event.stopPropagation();
	});
	$(".b-metro-map .st").click(function(event) {
		var checkbox = $(this).find("input");
		var checked = checkbox.prop("checked");
		checkbox.prop("checked", !checked);
		if(checkbox.data("related")) {
			var related = (typeof checkbox.data("related") === "number") ? [checkbox.data("related")] : checkbox.data("related").split(",");
			for (var i = 0; i < related.length; i++) {
				$(".b-metro-map").find("#rf_metro_" + related[i]).prop("checked", !checked);
			};
		}
		updateMetroMap();
	});
	updateMetroMap();
	function updateMetroMap() {
		var checked = $(".b-metro-map .st input:checked");
		if(checked.length == 0) {
			$(".metro-select > span").text("Станция метро");
		} else {
			if(checked.length == 1) {
				$(".metro-select > span").text(checked.parent().text());
			} else {
				$(".metro-select > span").text("Станции (" + checked.length + ")");
			}
		}
	}
	
});