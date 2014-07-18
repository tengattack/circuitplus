
function check_upload() {
  var form = $('#upload_form');
  /*
  var checkThings = ['.field#username', '.field#password'];
  var checkPass = true;

  $.each(checkThings, function (i, value) {
    var field = form.find(value);
    var input = field.find('input');
    if (!input.val()) {
      field.addClass('error');
      checkPass = false;
    } else {
      field.removeClass('error');
    }
  });

  if (checkPass)*/ {
    form.submit();
  }
}

function class_dropdown_change(value, text) {
  var d = $(this);
  var depth = d.data('depth');
  depth = parseInt(depth) + 1;
  var subclassDrop = $('.ui.dropdown#class' + depth);
  if (subclassDrop) {
    subclassDrop.next('.dropdown').remove();
    subclassDrop.remove();
  }
  if (depth < classifications.length) {
    d.after('<div class="ui selection dropdown" id="class' + depth + '"><div class="text">Select</div><i class="dropdown icon"></i><div class="menu"></div></div>');

    subclassDrop = $('.ui.dropdown#class' + depth);
    var subclassMenu = subclassDrop.find('.menu');
    var cl = classifications[depth];
    for (var i = 0; i < cl.length; i++) {
      if (parseInt(cl[i].parent_id) == parseInt(value)) {
        subclassMenu.append('<div class="item" data-value="' + cl[i].classification_id + '">' + cl[i].name + '</div>');
      }
    }
    subclassDrop.dropdown('active');
    subclassDrop.dropdown({
      onChange: class_dropdown_change
    });
  }

  $('input#class_id').val(value);
}


var cur_tag_value, cur_tag_text;

function tag_add(value, text) {
  if (!value) {
    return;
  }
  var tagWrapper = $('.tag-wrapper');
  if (tagWrapper.find('#tag' + value).length > 0) {
    return;
  }
  var tagInput = $('.tag-input');
  tagInput.append('<input type="hidden" name="circuit[tags][]" value="' + value + '">');
  tagWrapper.append('<div class="ui icon label" id="tag' + value + '"><i class="tag icon"><a href="/term/tag/' + value + '" target="_blank">' + text + '</a></div>');
}

$(document).ready(function () {

  var classDrop = $('.ui.dropdown#class0');
  var classMenu = classDrop.find('.menu');
  classDrop.data('depth', 0);
  for (var i = 0; i < classifications[0].length; i++) {
    classMenu.append('<div class="item" data-value="' + classifications[0][i].classification_id + '">' + classifications[0][i].name + '</div>');
  }

  classDrop.dropdown();
  classDrop.dropdown({
    onChange: class_dropdown_change
  });

  var tagDrop = $('.ui.dropdown#tag_add');
  var tagMenu = tagDrop.find('.menu');
  for (var i = 0; i < tags.length; i++) {
    tagMenu.append('<div class="item" data-value="' + tags[i].term_id + '">' + tags[i].name + '</div>');
  }

  tagDrop.find('.button').click(function () {
    //var tagdrop = $(this).parent();
    tag_add(cur_tag_value, cur_tag_text);
  });
  tagDrop.dropdown({
    onChange: function (value, text) {
      window.cur_tag_value = value;
      window.cur_tag_text = text;
    }
  });
});