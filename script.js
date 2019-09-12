(function($){
    const links = $(".lpcontent__content-schedule-image > a");
    links.each(function() {
        $(this).on("click", function(e) {
            const formType = $(this).data("formType");
            const selecteSchedule = $(".select-schedules");
            selecteSchedule.val(formType)
        })
    })
})(jQuery)