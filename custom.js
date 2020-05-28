$('document').ready(function() {
	$('.header-div').has('.magic').css('display', 'none');

	$.ajax({
		url: 'build',
		method: 'get',
		success(response) {
			build(response);
			if(localStorage.getItem('scrollY')){

                
                    
                    window.scrollTo(0, localStorage.getItem('scrollY'));
                    localStorage.setItem('scrollY', 0);
                }
		},
		error(err) {
		}
	});

	$('#audit_table').DataTable({
		language: {
			paginate: {
				first: '«',
				previous: '‹',
				next: '›',
				last: '»'
			},
			zeroRecords: 'Не було виконано жодної операції'
		},
		ordering: false,
		pagingType: "full_numbers",
		autoWidth: true,
		dom: 'Btp'
	});

	$('.delete-user').on('click', function() {
		if(confirm('Ви впевнені?')) {
			var data = {
				'id' : $(this).attr('data-id')
			};

			$.ajax({
				url: 'delete-user',
				method: 'post',
				data: data,
				success(response) {
					if(response == 0) {
						alert('Користувач успішно видалений');
						location.reload();
					}
					else {
						alert('Неможливо видалити самого себе');
					}
				},
				error(err) {
					alert('Виникла помилка при видалені користувача');
				}
			});
		}
	});

	var minimal = $('#minimal').val();
	var tar_roz = [];

	$('.math').parent().hide();

    $('#add #fond').clone().appendTo('#stufflist #fond-div');
    $('#stufflist #fond').addClass('col').removeClass('add-input');

    $('#stufflist #fond').children('option[value="1"]').remove();

	function build_sl_dt() {
		var sl= $('#sl').DataTable({
			dom: 'Bt',
			language: {
				zeroRecords: 'Немає жодного запису'
			},
			paging: false,
			ordering: false,
			buttons: [
				'excel'
			],
		});

		$('#sl-export').on('click', function() {
			sl.button().trigger('click');
		});
	}

	$.ajax({
		url: '/../tar_roz',
		method: 'get',
		success(response) {
			tar_roz = response;
			tar_roz[0] = "0";

			var no = Number($('#sl thead tr th').index($('#no'))+1);
			var unit_no = Number($('#sl thead tr th').index($('#cs'))+1);
			var rozryad_no = Number($('#sl thead tr th').index($('#rozryad'))+1);
			var sum_roz_no = Number($('#sl thead tr th').index($('#sum_tar_roz'))+1);
			var sum_oklad_no = Number($('#sl thead tr th').index($('#sum_oklad'))+1);
			var kafedra_no = Number($('#sl thead tr th').index($('#kafedra'))+1);
			var total_nadbavka_no = Number($('#sl thead tr th').index($('#total_nadbavka'))+1);
			var fond_month_no = Number($('#sl thead tr th').index($('#fond_month'))+1);
			var counter;

			for(var i = 1; i < $('#sl tr').length; i++) {
				$('#sl tr:nth-child('+i+') td:nth-child('+sum_roz_no+')').text(tar_roz[Number($('#sl tr:nth-child('+i+') td:nth-child('+rozryad_no+')').text().trim())]);
				$('#sl tr:nth-child('+i+') td:nth-child('+sum_oklad_no+')').text((Number($('#sl tr:nth-child('+i+') td:nth-child('+unit_no+')').text().trim()) * Number($('#sl tr:nth-child('+i+') td:nth-child('+sum_roz_no+')').text().trim())).toFixed(2));
				$('#sl tr:nth-child('+i+') td:nth-child('+fond_month_no+')').text((Number($('#sl tr:nth-child('+i+') td:nth-child('+sum_oklad_no+')').text().trim()) + Number($('#sl tr:nth-child('+i+') td:nth-child('+total_nadbavka_no+')').text().trim())).toFixed(2));

				if($('#sl tr:nth-child('+(i-1)+') td:nth-child('+kafedra_no+')').text() != $('#sl tr:nth-child('+i+') td:nth-child('+kafedra_no+')').text()) {
					$('<tr><td>&nbsp;</td><td>&nbsp;</td><td class="font-weight-bold">'+($('#sl tr:nth-child('+i+') td:nth-child('+kafedra_no+')').text().trim())+'</td>   <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>').insertBefore('#sl tr:nth-child('+i+'):has(td)');
					i++;
					counter = 0;
				}

				$('#sl tr:nth-child('+i+') td:nth-child('+Number(no)+')').text(++counter);
			}

			$('#sl td, #sl th').remove(':nth-child('+kafedra_no+')');

			var stazh_no = Number($('#sl thead tr th').index($('#stazh_roboty_p'))+1);
			$('#sl td, #sl th').remove(':nth-child('+stazh_no+')');

			var stupin_no = Number($('#sl thead tr th').index($('#doplata_za_stupin_p'))+1);
			$('#sl td, #sl th').remove(':nth-child('+stupin_no+')');

			var zvannya_no = Number($('#sl thead tr th').index($('#doplata_za_zvannya_p'))+1);
			$('#sl td, #sl th').remove(':nth-child('+zvannya_no+')');

			build_sl_dt();
		},
		error(err) {
		}
	});

	function build(data) {
		var datatable = $('#datatable').DataTable({
			data: data['arr'],
			columns: data['headers'],
			paging: false,
			fixedHeader: {
				header: false,
				footer: true,
				footerOffset: -6
			},
			language: {
				zeroRecords: 'Немає жодного запису'
			},
			autoWidth: true,
			dom: 'Bt',
			buttons: [
				'excel'
			]
		});

		$('#search').on( 'keyup', function () {
			datatable.search( this.value ).draw();
		});

		$('.maintable td:nth-child(1)').css('left', 0);
		$('.maintable td:nth-child(2)').css('left', $('.maintable td:nth-child(1)').outerWidth());
		$('.maintable td:nth-child(3)').css('left', $('.maintable td:nth-child(1)').outerWidth() + $('.maintable td:nth-child(2)').outerWidth());
		$('.maintable th:nth-child(1)').css('left', 0);
		$('.maintable th:nth-child(2)').css('left', $('.maintable th:nth-child(1)').outerWidth());
		$('.maintable th:nth-child(3)').css('left', $('.maintable th:nth-child(1)').outerWidth() + $('.maintable th:nth-child(2)').outerWidth());

		$('#export').on('click', function () {
			datatable.button('.buttons-excel').trigger('click');
		});

		var tbl_cells = $('#datatable td');
		var row_length = $('#datatable thead tr th').length;
		var counter = 0;

		for(var i = 0; i < tbl_cells.length; i++) {
			if(i%row_length == 1) {
				jQuery(tbl_cells[i]).text(++counter);
			}
			else if(i%row_length !== 0) {
				jQuery(tbl_cells[i])
					.wrapInner('<span class="cell-content"></span>')
					.addClass('cell');
			}
		}

		$('.copy-btn').on('click', function () {
			var counter = 2;
			var cell = $(this).parent().next();
			var id;

			while(cell.next().length) {
				cell = cell.next();
				id = $('thead th:nth-child(' + ++counter + ')').attr('id');

				if($('#add input[id="' + id + '"]').length) {
					$('#add input[id="' + id + '"]').val(cell.text());
				}
				else if($('#add select[id="' + id + '"]').length) {
					$('#add select[id="' + id + '"] option').each(function () {
						if($(this).text() === cell.text()) {
							$(this).prop('selected', true);
							return;
						}
					});
				}
			}

			$('button[data-target="#add"]').trigger('click');
		});

		//remove row from DB
		$('.remove-btn').on('click', function () {
			if(confirm('Ви впевнені?')) {
				const data = {
					'id': $(this).attr('id'),
					'prizvysche_im_ya_po_bat_kovi': $(this).parent().next().next().find('span').text()
				};

				$.ajax({
					url: 'remove-employee',
					method: 'post',
					data: data,
					beforeSend() {
						showProgressAlert()
					},
					complete() {
						hideProgressAlert()
					},
					success(response) {
						// $('#datatable').DataTable().destroy();
						// build(response);
						// showSuccessAlert('Запис видалено');
						 localStorage.setItem('scrollY', window.pageYOffset);
                        window.location.reload();
					},
					error(err) {
					}
				})
			}
		});

		//editing the field
		$('.cell').unbind('dblclick').on('dblclick', function () {
			if($('.table').hasClass('editing')) {
				return;
			}
			$(this).addClass('editing');
			$(this).children('.cell-content').hide();

			var head = $('thead th:eq('+$(this).parent().children().index($(this))+')');
			var title = head.attr('id');

			if(head.hasClass('enum')){
				var sel = $('#add select#'+title);

				$(this).append(sel.clone());
				$(this).children('select').addClass('editing-input').val(1);
			} else {
				if( $('input[type=text]#'+title).length) {
					var inp = $('input[type=text]#' + title);

					$(this).append(inp.clone());
					$(this).children('input').val($(this).children('.cell-content').text());
				}
				else {
					var inp = $('input[type=date]#' + title);
					$(this).append(inp.clone());
				}

				$(this).children('input').addClass('editing-input');
			}

			$(this).children('.editing-input').focus().select();
		});


		$('.cell').on('focusout', function () {
			$(this).children('.cell-content').show();
			$(this).removeClass('editing');
			$(this).children('.editing-input').remove();
			$('body').find('.err').remove();
		});

		$('#datatable').unbind('keypress').bind('keypress',  function (e) {
			if(e.which == 13) {
				editCell($('.cell').has(':focus'));
			}
		});

		$('#datatable').unbind('change').on('change', 'select', function() {
			editCell($('.cell').has(':focus'));
		});

		function editCell (elem)
		{
			if(!validate_edit(elem)) {
				return;
			}

			var item = elem.parent().children().index(elem);

			const data = {
				'name': $('thead th:eq('+item+')').attr('id'),
				'id': elem.parent().find('td:eq(' + 0 + ') .remove-btn').attr('id'),
				'value': elem.parent().find('.editing-input').val()
			};

			$.ajax({
				url: 'edit-employee',
				method: 'post',
				data: data,
				beforeSend() {
					showProgressAlert()
				},
				complete() {
					hideProgressAlert()
				},
				success(response) {
					// $('#datatable').DataTable().destroy();
					// build(response);
					// showSuccessAlert('Зміни внесено');
					localStorage.setItem('scrollY', window.pageYOffset);
                    window.location.reload();
				},
				error(err) {
				}
			})
		}

		function validate_edit(elem) {
			var flag = true;
			let item = elem.find('.add-input');

			if($('body').children().hasClass('err')) {
				$('body').find('.err').remove();
			}

			if($(item.attr('id') == 'data_zvil_nennya_perevedennya')) {
				return true;
			}

			if (item.hasClass('type-Text')
				&& item.val().match(/^[a-zA-Zа-яА-ЯїЇіІєЄёЁґҐъЪ0-9][\-\s,.'%\/+a-zA-Zа-яА-ЯїЇіІєЄёЁґҐъЪ0-9]{0,120}$/gium)) {
			} else if(item.hasClass('type-Double')
				&& item.val().match(/^(-)?[0-9]{1,8}([.,][0-9]{1,5})?$/gium)){
				item.val(item.val().replace(/,/gi, '.'));
			} else if(item.hasClass('type-Enum')) {
				//just leave
			}  else if(item.hasClass('type-Date')
				&& item.val().match(/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/gium)) {
			} else {
				if (!$('body').children().hasClass('err')) {
					$('body').append(" <div class='err alert alert-danger fixed-bottom text-center'>Помилка вводу!</div>");
				}

				flag = false;
			}

			return flag;
		}

		$('#filter-btn').on('click', function () {
			var colitems = $('.filter-column:not(:checked)');
			var filteredcols = $('#rows-filter .dropdown-toggle');
			var rows = $('thead tr, tbody tr');
			var n = rows.length;
			var m = jQuery(rows[0]).find('td, th').length;
			var col_items_id = [];
			var row_items_id = [];
			var rowarr = [];
			var kostyl = [];

			for(var i = 0; i < colitems.length; i++) {
				var id = jQuery(colitems[i]).attr('id');

				col_items_id.push($("thead th").index($("thead th#"+id))+1);
			}

			for(var i = 0; i < filteredcols.length; i++) {
				var id = jQuery(filteredcols[i]).attr('id');
				var no = $("thead th").index($("thead th#"+id))+1;

				row_items_id.push(no);
				rowarr[no] = [];
				kostyl.push(no);

				var temp = jQuery(filteredcols[i]).parent().find('.filter-checkbox:not(:checked)');

				for(var j = 0; j < temp.length; j++) {
					rowarr[no].push(jQuery(temp[j]).parent('label').text().trim());
				}
			}
			for(var i = 1; i < n+2; i++) {
				var flag = true;

				for(var j = 1; j < m+1; j++) {
					var item = jQuery(rows[i]).find('td:nth-child('+j+')');

					if(col_items_id.includes(j)) {
						item.hide();
						if(i == 1) {
							$('th:nth-child('+j+')').hide();
						}
					}
					else {
						item.show();
						if(i == 1) {
							$('th:nth-child('+j+')').show();
						}
					}
					if(item.is('tbody td') && kostyl.length > 0 && kostyl.includes(j) && rowarr[j].includes(item.text().trim())){
						flag = false;
					}
				}
				if(flag) {
					$('tbody tr:nth-child(' + (i) + ')').show();
				}
				else {
					$('tbody tr:nth-child(' + (i) + ')').hide();
				}
			}

			//date filter
			$('.start-date').each(function() {
				var temp_id = jQuery(this).attr('id').substr(3);
				var start_val = new Date(jQuery(this).val());
				var end_val = new Date($('#'+jQuery(this).attr('id')+'.end-date').val());
				var no = $("thead th").index($("thead th#"+temp_id))+1;
				var rows = $('tr');

				for(var j = 1; j < rows.length; j++ ) {
					var temp_date = new Date(jQuery(rows[j]).find('td:nth-child('+no+')').text());

					if(start_val.getTime() > temp_date.getTime() || end_val.getTime() < temp_date.getTime()) {
						jQuery(rows[j]).hide();
					}
				}
			});

			//restripe table
			$('.table-striped tbody tr:visible').each(function(i) {
				if(!(i%2)) {
					$(this).css("background-color", "rgba(0, 0, 0, 0.05)");
				}
				else {
					$(this).css("background-color", "rgba(0, 0, 0, 0.00)");
				}
			});

			var tbl_cells = $('#datatable td');
			var row_length = $('#datatable thead tr th').length;
			var counter = 0;

			for(var i = 0; i < tbl_cells.length; i++) {
				if (i % row_length == 1 && jQuery(tbl_cells[i]).parents('tr').css('display') != 'none') {
					jQuery(tbl_cells[i]).text(++counter);
				}
			}

			datatable.columns.adjust().draw();
		});

		$('tbody tr').off('click').on('click', function () {
			$('.fired').removeClass('fired');
			$(this).addClass('fired');
		});
	}

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#filter-column-all').off('change').on('change', function(){
		$('.filter-column').prop('checked', $('#filter-column-all').prop('checked'));
	});

	//on filter selected
	$('.dropdown-filter-div .dropdown-item').on('click', function () {
		var _this = $(this);
		var str = "";
		var id = _this.attr('id');
		var no = $("thead th").index($("thead th#"+id))+1;

		str += "<div class='row my-1'>";
		str += "<div class='col-10 pl-0 dropdown'>";
		str += "<button class='btn btn-secondary dropdown-toggle w-100' type='button' id='"+id+"' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+_this.text()+"</button>";
		str += "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";

		if($("input#"+id+".add-input").hasClass('type-Date')) {
			str += "<a class='dropdown-item'><label class='w-100'>Від:&nbsp;<input type='date' id='id-"+id+"' class='start-date date-filter'></label></a>";
			str += "<a class='dropdown-item'><label class='w-100'>До:&nbsp;&nbsp;<input type='date' id='id-"+id+"' class='end-date date-filter'></label></a>";
		}
		else {
			var elem = $('td:nth-child(' + no + ')');
			var hasEmpty = false;

			elem.each(function () {
				var temp = $(this).text().trim();

				if (str.search('&nbsp;' + temp + '</label>') < 0 || (!hasEmpty && temp.length < 1)) {
					str += "<a class='dropdown-item'><label class='w-100'><input type='checkbox' class='filter-checkbox' checked>&nbsp;" + temp + "</label></a>";
					hasEmpty = temp.length < 1 ? true : hasEmpty;
				}
			});
		}

		str += "</div>";
		str += "</div>";
		if($("input#"+id+".add-input").hasClass('type-Date')) {
			str += "<span class = 'col'></span>";
		}
		else {
			str += "<button type='button' class='col uncheck-btn btn btn-outline-primary' data-toggle='1'>&#9745;</button>";
		}
		str += "<button type='button' class='col enum-minus btn btn-outline-danger'>&times;</button>";
		str += "</div>";

		$(str).appendTo('.filter-div');
		_this.hide();

		$('.enum-minus').on('click', function () {
			$(this).parent().remove();
			_this.show()
		});

		$('.uncheck-btn').off('click').on('click', function () {
			if($(this).attr('data-toggle') == 1) {
				$(this).prev().find('input:checkbox').prop('checked', false);
				$(this).attr('data-toggle', 0);
				$(this).html('&#9744;');
			}
			else {
				$(this).prev().find('input:checkbox').prop('checked', true);
				$(this).attr('data-toggle', 1);
				$(this).html('&#9745;');
			}
		});

		$('.filter-checkbox').on('change', function () {
			var button = $(this).closest('.my-1').find('.uncheck-btn');
			button.attr('data-toggle', 0);
			button.html('&#9744;');
		});

		$('.dropdown-menu').on('click', function() {
			$(this)
				.addClass('show')
				.parent()
				.addClass('show')
				.children('button')
				.attr('aria-expanded', true);
		})
	});

	//add row to DB//
	$('#add-btn').off().on('click', function (e) {
		e.preventDefault();

		if (!validate_add()) {
			return;
		}

		var inputs = $('.add-input');
		var arr = {};

		for (var i = 0; i < inputs.length; i++) {
			arr[jQuery(inputs[i]).attr('id')] = jQuery(inputs[i]).val();
		}

		arr['posadovyy_oklad'] = Number(tar_roz[Number($('select#taryu_rozryad').val()) - 1]);
		arr['zarobitna_plata'] = Number(arr['chastyna_stavky'] * arr['posadovyy_oklad']).toFixed(2);
		arr['doplata_za_stupin'] = Number(arr['zarobitna_plata'] * (arr['doplata_za_stupin_p'] / 100)).toFixed(2);
		arr['doplata_za_zvannya'] = Number(arr['zarobitna_plata'] * (arr['doplata_za_zvannya_p'] / 100)).toFixed(2);
		arr['nadbavka_za_stazh'] = Number(arr['zarobitna_plata'] * (arr['stazh_roboty_p'] / 100)).toFixed(2);
		arr['inshi_doplaty'] = Number((arr['inshi_doplaty_p'] / 100) * arr['posadovyy_oklad']).toFixed(2);
		arr['doplata_do_minimal_noyi_zarobitnoyi_platy'] = (Number(arr['chastyna_stavky']) * minimal - (Number(arr['zarobitna_plata']) + Number(arr['doplata_za_stupin']) + Number(arr['doplata_za_zvannya']) + Number(arr['nadbavka_za_stazh']) + Number(arr['inshi_doplaty']))).toFixed(2);
		arr['doplata_do_minimal_noyi_zarobitnoyi_platy'] = (Number(arr['doplata_do_minimal_noyi_zarobitnoyi_platy']) > 0) ? (arr['doplata_do_minimal_noyi_zarobitnoyi_platy']) : 0;
		arr['premiya'] = arr['premiya_schomisyachna_premiya'];
		arr['misyachna_zarobitna_plata'] = (Number(arr['zarobitna_plata']) + Number(arr['doplata_za_stupin']) + Number(arr['doplata_za_zvannya']) + Number(arr['nadbavka_za_stazh']) + Number(arr['inshi_doplaty']) + Number(arr['premiya']) + Number(arr['doplata_do_minimal_noyi_zarobitnoyi_platy'])).toFixed(2);

		const data = arr;


		$.ajax({
			url: 'create-employee',
			method: 'post',
			data: data,
			beforeSend() {
				showProgressAlert();
			},
			complete() {
				hideProgressAlert();
			},
			success(response) {
				// $('#datatable').DataTable().destroy();
				// build(response);
				// showSuccessAlert('Запис додано');
				localStorage.setItem('scrollY', window.pageYOffset);
                window.location.reload();
			},
			error(err) {
			}
		})
	});

	//add column to DB
	$('#edit-add-btn').on('click', function () {
		if (!validate_col_name()) {
			return;
		}

		if (!validate_enum('#add-column')) {
			return;
		}

		var items = $('#add-column .enum-input');
		var arr = [];

		for (var i = 0; i < items.length; i++) {
			arr[i] = jQuery(items[i]).val();
		}

		const data = {
			'column_name': $('#column_name').val(),
			'column_type': $('#column_type').val(),
			'enum': arr,
			'required': $('#required-checkbox:enabled').is(':checked') ? "required" : ""
		};

		$.ajax({
			url: 'edit-add-column',
			method: 'post',
			data: data,
			success(response) {
				alert('Готово');
				location.reload();
			},
			error(err) {
				var str = JSON.parse(err.responseText);
				showErrorAlert(str);
			}
		})
	});

	//remove column from DB
	$('#edit-remove-btn').on('click', function () {
		var items = $('.remove-item:checked');
		var arr = [];

		for (var i = 0; i < items.length; i++) {
			arr[i] = jQuery(items[i]).attr('id');
		}

		const data = {'data': arr};

		$.ajax({
			url: 'edit-remove-column',
			method: 'post',
			data: data,
			success(response) {
				alert('Готово');
				location.reload();
			},
			error(err) {
			}
		})
	});

	//edit column of DB
	$('#edit-edit-btn').on('click', function () {
		if (!validate_enum('#edit-column')) {
			return;
		}

		var items = $('#edit-column .enum-input');
		var arr = [];

		for (var i = 0; i < items.length; i++) {
			arr[i] = {
				val: jQuery(items[i]).val(),
				id: jQuery(items[i]).attr('id')
			}
		}

		const data = {
			'id': $('#edit-column .text-input').attr('id'),
			'column_name': $('#edit-column .text-input').val(),
			'enum': arr
		};

		$.ajax({
			url: 'edit-edit-column',
			method: 'post',
			data: data,
			success(response) {
				alert('Готово');
				location.reload();
			},
			error(err) {
			}
		})
	});

	//edit consts
	$('#edit-const-btn').on('click', function () {
		var mnml = $('#edit-const #minimal').val();
		var tr = [];

		for (var i = 0; i < 20; i++) {
			tr[i] = $('#tar_roz'+(i+1)).val();
		}

		const data = {
			'minimal': mnml,
			'tar_roz': tr
		};

		$.ajax({
			url: 'edit-const',
			method: 'post',
			data: data,
			success(response) {
				alert('Готово');
				location.reload();
			},
			error(err) {
			}
		})
	});

	$('#stufflist-btn').off('click').on('click', function() {
		var start = new Date($('#sl_start_date').val());
		var end = new Date($('#sl_end_date').val());

		if(start.getTime() <= end.getTime()) {
			$('#sl-alert').remove();
			window.open('stufflist/' + $('#sl_start_date').val().trim() + '/' + $('#sl_end_date').val().trim()+ '/' + $('#stufflist #fond').val(), '_blank')
		}
		else {
			$('#stufflist .modal-body').append('<div id="sl-alert" class="alert alert-danger">Невірно введені дані</div>');
		}
	});

	$('#drop-table').off('click').on('click', function () {
		if(confirm('Ви впевнені? (всі дані буде видалено)')) {
			$.ajax({
				url: 'drop-table',
				method: 'post',
				success(response) {
					alert('Готово');
					location.reload()
				},
				error(err) {
				}
			});
		}
	});

	$('#column_type').unbind('change').on('change', function () {
		if($(this).val() == 'Enum') {
			$("<div class='enum input-group my-1'><input class='enum-input form-control' maxlength='120' disabled placeholder='Немає даних'><div class='input-group-append'><input type='button' class='enum-plus btn btn-outline-primary' value='+'></div></div>").appendTo($('#add-column .enum-div'));
			$('.required-div').hide().children('input').attr('disabled', true);
		} else {
			$('.enum-div').find('.enum').remove();
			$('.required-div').show().children('input').attr('disabled', false);
		}
		// +/- actions
		$('#add-column').unbind('click').on('click', '.enum-plus', function () {
			if($('#add-column .enum-input').length < 50) {
				$("<div class='enum input-group my-1'><input class='enum-input form-control' maxlength='120'><div class='input-group-append'><input type='button' class='enum-minus btn btn-outline-danger' value='-'></div></div>").appendTo($('#add-column .enum-div'));
			} else {
				alert("Максимум 50 записів");
			}
			$('#add-column').on('click', '.enum-minus', function () {
				$(this).parent().parent().remove();
			});
		});
	});

	//editing column name and enums
	$('.edit-btn-group button').on('click', function() {
		var id = $(this).attr('id');
		var val = $('#datatable #'+id).html().trim();
		var flag = $('#datatable #'+id).hasClass('enum');
		var str = "";

		$('.edit-btn-group').hide();

		str += "<div class='col editing-div'>";
		str += "<div class='row'>";
		str += "<button class='col btn btn-secondary top-btn' id='reset-edit' type='button'>Скинути</button>";
		str += "</div>";
		str += "<div class='row'>";
		str += "<label for='column_name' class='small'>Назва</label>";
		str += "<input type='text' class='text-input form-control form-control-sm' id='"+id+"' value=''>";
		str += "</div>";
		str += "<div class='row enum-div'></div>";
		str += "</div>";

		$(str).prependTo('#edit-column');

		$('#reset-edit').on('click', function() {
			$('.editing-div').remove();
			$('.edit-btn-group').show();
		});

		$('#edit-column #'+id).val(val);

		if(flag) {
			var first = true;
			var counter;

			$('#'+id+'.add-input option').each( function (){
				counter = $(this).val();

				if(first) {
					$("<div class='enum input-group my-1'><input id='val"+counter+"' class='existed enum-input form-control' maxlength='120' disabled placeholder='Немає даних'><div class='input-group-append'><input type='button' class='enum-plus btn btn-outline-primary' value='+'></div></div>").appendTo($('#edit-column .enum-div'));

				}
				else {
					$("<div class='enum input-group my-1'><input id='val"+counter+"' class='existed enum-input form-control' maxlength='120' value=''><div class='input-group-append'><input type='button' class='enum-minus btn btn-outline-danger' value='-'></div></div>").appendTo($('#edit-column .enum-div'));
					var temp = $(this).text();
					$('#edit-column #val'+counter).val(temp);
				}

				first = false;
			});

			// +/- actions
			$('#edit-column .enum-plus').on('click', function () {
				if($('#edit-column .enum-input').length < 50) {
					$("<div class='enum input-group my-1'><input id='val0' class='enum-input form-control' maxlength='120'><div class='input-group-append'><input type='button' class='enum-minus btn btn-outline-danger' value='-'></div></div>").appendTo($('#edit-column .enum-div'));
				} else {
					alert("Максимум 50 записів");
				}
			});

			$('#edit-column').on('click', '.enum-minus', function () {
				$(this).parent().parent().remove();
			});
		}
	});

	//Validation
	function validate_col_name() {
		if($('#column_name').prev().children().hasClass('err')) {
			$('#column_name').parent().find('.err').remove();
		}
		if($('#column_name').val().match(/^[a-zA-Zа-яА-ЯїЇіІєЄёЁґҐъЪ№#][-\s,.'%/#№+a-zA-Zа-яА-ЯїЇіІєЄёЁґҐъЪ0-9]{0,63}$/gium)) {
			$('#edit-add-btn').attr('data-dismiss', 'modal');

			return true;
		} else {
			if(!$('#column_name').prev().children().hasClass('err')) {
				$('#column_name').prev().append(" <span class='err alert-danger'>Помилка вводу!</span>");
			}

			return false;
		}
	}

	function validate_enum(str) {
		var inputs = $(str+' .enum-input');
		var flag = true;

		$('#edit-add-btn').attr('data-dismiss', 'modal');
		$('#edit-edit-btn').attr('data-dismiss', 'modal');

		for(var i=0; i < inputs.length; i++) {
			let item = jQuery(inputs[i]);

			if (item.val().match(/^[-\s,.'%/#№+a-zA-Zа-яА-ЯїЇіІєЄёЁґҐъЪ0-9]{0,120}$/gium)) {
				item.removeClass('is-invalid');
			} else {
				$('#edit-add-btn').attr('data-dismiss', '');
				$('#edit-edit-btn').attr('data-dismiss', '');

				item.addClass('is-invalid');
				flag = false;
			}
		}

		return(flag);
	}

	function validate_add() {
		var inputs = $('.add-input');
		var flag = true;

		for(var i = 0; i < inputs.length; i++) {
			let item = jQuery(inputs[i]);

			if(item.prev().children().hasClass('err')) {
				item.parent().find('.err').remove();
			}
			if (item.hasClass('type-Text')
				&& (item.val().match(/^[a-zA-Zа-яА-ЯїЇіІєЄёЁґҐъЪ0-9][-\s,.'%\/+a-zA-Zа-яА-ЯїЇіІєЄёЁґҐъЪ0-9()]{0,120}$/gium)
					|| (!item.hasClass('required') && item.val().match(/^$/gium)))) {
			} else if(item.hasClass('type-Double')
				&& (item.val().match(/^(-)?[0-9]{1,8}([.,][0-9]{1,5})?$/gium))
				|| (!item.hasClass('required') && item.val().match(/^$/gium))){
				item.val(item.val().replace(/,/gi, '.'));
			} else if(item.hasClass('type-Enum')) {
				//just leave
			} else if(item.hasClass('type-Date')
				&& item.val().match(/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/gium)) {
			} else {
				if(!item.hasClass('required')){
				}
				if (!item.prev().children().hasClass('err')) {
					item.prev().append(" <span class='err alert-danger'>Помилка вводу!</span>");
				}

				flag = false;
			}
		}

		if(flag) {
			$('#add-btn').attr('data-dismiss', 'modal');
		}

		return flag;
	}
});

function xlr() {
	document.body.innerHTML = "<canvas id='canvas' class='align-middle' style='width: 300px; height: 300px; margin: 50px'></canvas>";

	var can = document.getElementById('canvas');
	var z = can.getContext("2d");

	z.strokeStyle = '#AA3300';

	return z;
}

function showProgressAlert() {
	$('<div class="alert alert-warning fixed-top text-center">Запит виконується...</div>').appendTo('body');
	$('html').addClass('wait');
}

function hideProgressAlert() {
	$('.alert-warning').remove();
	$('html').removeClass('wait');
}

function showSuccessAlert(str) {
	$('<div class="alert alert-success fixed-bottom text-center">'+str+'</div>').hide().appendTo('body').slideDown("fast", "swing");

	setTimeout(function() {
		$(".alert").slideUp("fast", "swing");
		setTimeout(function() {
			$(".alert").remove();
		}, 400)
	}, 2000);
}

function showErrorAlert(str) {
	$('<div class="alert alert-danger fixed-bottom text-center">'+str+'</div>').hide().appendTo('body').slideDown("fast", "swing");

	setTimeout(function() {
		$(".alert").slideUp("fast", "swing");
		setTimeout(function() {
			$(".alert").remove();
		}, 400)
	}, 2000);
}