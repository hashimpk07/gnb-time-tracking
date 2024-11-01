$(document).ready(function(){
	$("#save").click(saveData);
	$("[name='week']").click(function(){
		mode = "insert";
		$("[name='name']").val("");
		$("#save").attr("value", "New Week Add");
	})
	$("body").on("click", ".edit", function(){
		mode = "update";
		$("#save").attr("value", "Edit");
		idTarget = $(this).attr("data-id");
		getData(idTarget);
	});
	$("body").on("click", ".delete", function(){
		idTarget = $(this).attr("data-id");
		var temp = confirm("Are you sure?");
		if(!temp){
			return false;
		}else{
			deleteData(idTarget);
		}
	});
	loadData();

	var mode = "insert";
	var idTarget = -1;

	var data;
	var weekName;
    var fromDate;
	var toDate;

	function getValue(){
		data = new FormData();
		name = $("[name='name']").val();
        fromData = $("[name='from_date']").val();
        toData = $("[name='to_date']").val();
		data.append("mode", mode);
		data.append("id", idTarget);
		data.append("name", name);
        data.append("fromData", fromData);
        data.append("toData", toData);	
	}

	function saveData(){
		getValue();
		if(weekName == ""){
			alert("Please enter week name");
		}else if(weekName == ""){
			alert("Please enter week name");
		}else if(weekName == ""){
			alert("Please enter week name");
		}else{
			if(mode=="insert"){
				insertData();
			}else if(mode=="update"){
				updateData();
			}
		}
	};

	function insertData(){
		$('#loading').show();
		getValue();
		$.post({
			url : "../controller/weeks.php",
			data : data,
			contentType : false, 
			processData: false, 
			success : function(){
				loadData();
			},
			complete : function(){
				$('#loading').hide();
			}
		});
	}

	function getData($id){
		$.get({
			url : "../controller/weeks.php",
			data : {mode:'loadOne', id:idTarget},
			success : function(data){
				var temp = JSON.parse(data);
				$("[name='name']").val(temp.name);
                $("[name='from_date']").val(temp.from_date);
                $("[name='to_date']").val(temp.to_date);
			}
		});
	}

	function updateData(){
		$('#loading').show();
		getValue();
		$.post({
			url : "../controller/weeks.php",
			data : data,
			contentType : false, 
			processData: false, 
			success : function(){
				loadData();
				clearForm();
			},
			complete : function(){
				$('#loading').hide();
			}
		});
	}

	function loadData(){
		$.get({
			url : "../controller/weeks.php",
			data : {mode:'load'},
			success : function(data){
				$("body table tbody").html(data);
			}
		});
		clearForm();
	};

	function deleteData(id){
		$('#loading').show();
		$.get({
			url : "../controller/weeks.php",
			data : {mode:"delete", id:idTarget},
			success : function(){
				loadData();
				clearForm();
			},
			complete : function(){
				$('#loading').hide();
			}
		});
	}

	function clearForm(){
		$("[name='name']").val("");
        $("[name='from_date']").val("");
        $("[name='to_date']").val("");
		data = new FormData();
		mode = "insert";
		$("#save").attr("value", "New Week Add");
		idTarget = -1;
	}
})