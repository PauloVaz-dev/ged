$(document).ready(function () {
    var o = this;

    $('#rootwizard1').bootstrapWizard({
        onTabClick: function(tab, navigation, index){
            return true
        },
        onTabShow: function(tab, navigation, index) {
          // handleTabShow(tab, navigation, index, $('#rootwizard1'));

        },

    });

    function handleTabShow(tab, navigation, index, wizard){
        var total = navigation.find('li').length;
        var current = index + 0;
        var percent = (current / (total - 1)) * 100;
        var percentWidth = 100 - (100 / total) + '%';
        //console.log(navigation)
        navigation.find('li').removeClass('done');
        navigation.find('li.active').prevAll().addClass('done');

        wizard.find('.progress-bar').css({width: percent + '%'});
        $('.form-wizard-horizontal').find('.progress').css({'width': percentWidth});
    };

    var count = 2
    var current = count + 0;
    var percent = (current / (4 - 1)) * 100;
    var percentWidth = 100 - (100 / 4) + '%';

    $('#tabs-solar div.tab-pane').removeClass('active')
    //console.log($($('#tabs-solar div.tab-pane')[count]).addClass('active'))

    for(i = 0 ; i < count ; i++){
        $($( '#teste > li' )[i]).addClass('done');
    }
    count = 0

    $('#rootwizard1').find('.progress-bar').css({width: percent + '%'});
    $('.form-wizard-horizontal').find('.progress').css({'width': percentWidth});

});