function changeSelectType(select,id)
{	
	switch (select.value) {
	case '2':
	case '3':
	case '4':
		$(id+'_selectattributecode').hide();
		$(id+'_staticvalue').hide();
		break;
	case '5':
		$(id+'_selectattributecode').hide();
		$(id+'_staticvalue').show();
		break;
	case '1':
		$(id+'_selectattributecode').show();
		$(id+'_staticvalue').hide();
		break;
	case '':
		select.addClassName('required-entry');
		$(id+'_selectattributecode').show();
		$(id+'_staticvalue').show();
		break;	
	}
}