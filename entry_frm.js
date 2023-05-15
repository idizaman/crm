	
function frmChk(form)
	{
			
			
			
			var campaign= document.getElementById('campaign');
			
			
			if(campaign.value=="")
					{
					window.alert('Selection of Campaign Required');
					form.campaign.focus();
					return false;
					}
			
			
			else
					{
					return true;
					}
	//alert('ok');			
	}
function populateFeedback1(form)
{
	var NA="-1";
	form.fdbk1.length=0;
	form.fdbk2.length=0;
	form.fdbk1.add(new Option("--Choose Feedback1--", ""));
	form.fdbk2.add(new Option("--Choose Feedback2--", ""));
	selectedText=form.campaign.options[form.campaign.options.selectedIndex].value;
	
	for(var i=0; i<arrfdbk1.length;i++)
	{
		if(selectedText==arrfdbk1[i][1])
		form.fdbk1.add(new Option(arrfdbk1[i][2],arrfdbk1[i][0]));
	}
}

/**************************Union Populator**********************************/
function populateFeedback2(form)
{
	
	form.fdbk2.length=0;
	form.fdbk2.add(new Option("--Choose Feedback2--", ""));
	selectedText=form.fdbk1.options[form.fdbk1.options.selectedIndex].value;
	
	for(var i=0; i<arrfdbk2.length;i++)
	{
		if(selectedText==arrfdbk2[i][1])
		form.fdbk2.add(new Option(arrfdbk2[i][2],arrfdbk2[i][0]));
	}
	//alert(selectedText);
}

/*function f_chk(form)
{
	selectedText=form.fdbk2.options[form.fdbk2.options.selectedIndex].value;
	alert(selectedText);
}*/

/*
function chkid(x)
{

// only allow numbers to be entered
	var checkOK = "0123456789";
	var checkStr = x.value;
	var allValid = true;
	var allNum = "";
	for (i = 0;  i < checkStr.length;  i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
		if (ch == checkOK.charAt(j))
		break;
		if (j == checkOK.length)
		{
		allValid = false;
		break;
		}
		if (ch != ",")
		allNum += ch;
	}
	if (!allValid)
	{
	alert("Please enter only digit in the required field.");
	x.value="";
	x.focus();
	return false;
	}
	
	return true;

	//alert(x);	
}*/