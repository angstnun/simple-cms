$components_array = {'sidebar' : 'sidebar-list', 'page' : 'page-list', 'category' : 'category-list', 'article' : 'article-list'};

function addListItem($list, $component, $value, $text)
{
	$inputName = arraySearchKey($components_array,
			$component);
	$inputName = $inputName.concat('[', $list.getElementsByTagName('li').length ,"][id]");
	$li = createListItem($text);
	$a = addOnClick(createButton('Delete item'), removeListItem);
	$input = createInputElement('hidden', $inputName , $value);
	$li.appendChild($input);
	$li.appendChild($a);

	if($component == 'category')
	{
		$displayStyle = document.createElement('div');
		$displayStyle.className = 'category-display-style';
		$li.appendChild(document.createElement('br'));
		$label = document.createElement('label');
		$li.appendChild($label);

		for($i=1;$i<4;$i++)
		{
			if($i==1)
			{
				$element_div = document.createElement('div');
				$displayTypeInput = createInputElement('radio', 'category-list[' + ($list.getElementsByTagName('li').length) + "][displayStyle]", $i);
				$displayTypeInput.checked = true;
				$labelRows = document.createElement('label');
				$labelRows.innerText = 'Rows';
				$element_div.appendChild($displayTypeInput);
				$element_div.appendChild(document.createTextNode(' '));
				$element_div.appendChild($labelRows);
				$element_div.appendChild(document.createTextNode(' '));
				$displayStyle.appendChild($element_div);
			}
			else if($i==2)
			{
				$element_div = document.createElement('div');
				$displayTypeInput = createInputElement('radio', 'category-list[' + ($list.getElementsByTagName('li').length) + "][displayStyle]", $i);
				$labelColumns = document.createElement('label');
				$labelColumns.innerText = 'Columns';
				$element_div.appendChild($displayTypeInput);
				$element_div.appendChild(document.createTextNode(' '));
				$element_div.appendChild($labelColumns);
				$element_div.appendChild(document.createTextNode(' '));
				$displayStyle.appendChild($element_div);
			}
			else if($i==3)
			{
				$element_div = document.createElement('div');
				$displayTypeInput = createInputElement('radio', 'category-list[' + ($list.getElementsByTagName('li').length) + "][displayStyle]", $i);
				$labelList = document.createElement('label');
				$labelList.innerText = 'List';
				$element_div.appendChild($displayTypeInput);
				$element_div.appendChild(document.createTextNode(' '));
				$element_div.appendChild($labelList);
				$element_div.appendChild(document.createTextNode(' '));
				$displayStyle.appendChild($element_div);
			}
		}
		$li.appendChild($displayStyle);
		$li.appendChild(document.createElement('br'));

		$displayLocation = document.createElement('div');
		$displayLocation.className = 'category-display-location';
		for($i=0;$i<3;$i++)
		{
			if($i == 0)
			{
				$element_div = document.createElement('div');
				$inputName = 'category-list[' + $list.getElementsByTagName('li').length + "][is_in_lnavbar]";
				$labelLeft = document.createElement('label');
				$labelName = 'Left navbar';
				$labelLeft.innerText = $labelName;
				$where_to_display = createInputElement('checkbox', $inputName, true);
				$element_div.appendChild($where_to_display);
				$element_div.appendChild(document.createTextNode(' '));
				$element_div.appendChild($labelLeft);
				$element_div.appendChild(document.createTextNode(' '));
				$displayLocation.appendChild($element_div);
			}
			else if($i == 1)
			{
				$element_div = document.createElement('div');
				$inputName = 'category-list[' + $list.getElementsByTagName('li').length + "][is_in_rnavbar]";
				$labelName = 'Right navbar';
				$labelRight = document.createElement('label');
				$labelRight.innerText = $labelName;
				$where_to_display = createInputElement('checkbox', $inputName, true);
				$element_div.appendChild($where_to_display);
				$element_div.appendChild(document.createTextNode(' '));
				$element_div.appendChild($labelRight);
				$element_div.appendChild(document.createTextNode(' '));
				$displayLocation.appendChild($element_div);
			}
			else if($i == 2)
			{ 
				$element_div = document.createElement('div');
				$inputName = 'category-list[' + $list.getElementsByTagName('li').length + "][is_in_body]";
				$labelName = 'Body ';
				$labelBody = document.createElement('label');
				$labelBody.innerText = $labelName;
				$where_to_display = createInputElement('checkbox', $inputName, true);
				$where_to_display.checked = true;
				$element_div.appendChild($where_to_display);
				$element_div.appendChild(document.createTextNode(' '));
				$element_div.appendChild($labelBody);
				$element_div.appendChild(document.createTextNode(' '));
				$displayLocation.appendChild($element_div);
			}
		}
		$li.appendChild($displayLocation);
		$li.appendChild(document.createElement('br'));

		$order_div = document.createElement('div');
		$order_div.className = 'category-order';
		
		$element_div = document.createElement('div');
		$label.innerHTML = 'Ascending';
		$how_to_display = createInputElement('radio', 'category-list[' + $list.getElementsByTagName('li').length + "][is_ordered_asc]", true);
		$how_to_display.checked = true;
		$element_div.appendChild($how_to_display);
		$element_div.appendChild(document.createTextNode(' '));
		$element_div.appendChild($label);
		$element_div.appendChild(document.createTextNode(' '));

		$order_div.appendChild($element_div);

		$element_div = document.createElement('div');
		$label = document.createElement('label');
		$label.innerHTML = 'Descending';
		$how_to_display = createInputElement('radio', 'category-list[' + $list.getElementsByTagName('li').length + "][is_ordered_asc]", false);
		$element_div.appendChild($how_to_display);
		$element_div.appendChild(document.createTextNode(' '));
		$element_div.appendChild($label);
		$element_div.appendChild(document.createTextNode(' '));

		$order_div.appendChild($element_div);
		$li.appendChild($order_div);
	}
	$list.appendChild($li);
}

function removeListItem(event)
{
	event.target.parentElement.parentElement.removeChild(event.target.parentElement);
}

function createInputElement($type, $name, $value)
{
	$input = document.createElement('input');
	$input.type = $type;
	$input.name = $name;
	$input.value = $value;

	return $input;
}


function createButton($text)
{
	$button = document.createElement('button');
	$button.innerHTML = $text;
	return $button;
}

function getSelectOption($select)
{
	return $select.options[$select.selectedIndex].text;
}

function getSelectValue($select)
{
	return $select.options[$select.selectedIndex].value;
}

function createLink($href, $text)
{
	$a = document.createElement('a');
	$a.href = $href;
	$a.innerHTML = $text;
	return $a;
}

function addOnClick($element, $closure)
{
	$element.addEventListener('click', $closure);
	return $element;
}

function createListItem($text)
{
	$li = document.createElement('li');
	$li.innerHTML = $text;
	return $li;
}

function addComponentToList($component)
{
	if($component.length > 0)
	{
		$list = document.getElementById(arraySearchKey($components_array,
			$component[0]));
	}
	else
	{
		$component = document.getElementById('component-choice').value;
		$list = document.getElementById(arraySearchKey($components_array,
			$component));	
	} 
	if(!searchList($list, document.getElementById('component-names').value))
	{
		addListItem($list, $component,
			document.getElementById('component-names').value,
			getSelectOption(document.getElementById('component-names')));
	}
	else
	{
		alert('You cant add duplicate content');
	}
}

function searchList($list, $value)
{
	$lis = $list.getElementsByTagName('li');
	for($i=0;$i < $lis.length;$i++) if($lis[$i].getElementsByTagName('input')[0].value == $value) return true;
		return false
}

function arraySearchKey($array, $target)
{
	for($key in $array)
	{
		if($key == $target) return $array[$key];
	}
	return null;
}


//Dynamic select tags

function ajaxCall($url, $successClosure, $errorClosure)
{
	$xhr = new XMLHttpRequest();
	$xhr.open('POST', $url);
	$xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	$xhr.responseType = 'json';
	$xhr.onload = function() {
	    if ($xhr.status === 200) {
	        $successClosure($xhr.response);
	    }
	    else if ($xhr.status !== 200) {
	        $errorClosure($xhr.status);
	    }
	};
	$xhr.send();
};

function getOnChangeValue(event)
{
	return event.target.value;
}

function retrieveComponentsId(event)
{
	retrieveComponents(getOnChangeValue(event), populateComponentsNames, alert);
}

function initializeComponentNames($component)
{
	retrieveComponents($component, populateComponentsNames, alert);
}

function retrieveComponents($componentType, $closure, $defaultClosure)
{
	switch($componentType)
	{
		case 'page':
			ajaxCall('/getPages', $closure, alert);
			break;
		case 'article':
			ajaxCall('/getArticles', $closure, alert);
			break;
		case 'category':
			ajaxCall('/getCategories', $closure, alert);
			break;
		default:
			$defaultClosure('Error looking for component type');
			break;
	}
}

function populateComponentsNames($values)
{
	populateSelect(document.getElementById('component-names'), $values);
}

function populateSelect($select, $components)
{
	empty($select);
	for($i=0;$i<$components.length;$i++) $select.appendChild(createOption($components[$i].id, $components[$i].title));
}

function createOption($value, $text)
{
	$option = document.createElement('option');
	$option.value = $value;
	$option.innerHTML = $text;
	return $option;
}

function empty($element)
{
	while($element.firstChild) $element.removeChild($element.firstChild);
}