// JavaScript Document

//获取相同名称的input信息
function getValue(){
	var inputs = ['username','password','email'];
	var arrayAll = [];
	var values = [];
	for(var i = 0;i < inputs.length;i++){
		//获取相同名称的input值
		 values[i] = $("input[name="+inputs[i]+"]").map(function(){ 
			 return $(this).val(); 
		}).get();
		
	}
	
	//合并多维数组
	/*arrayAll.push([values[j][0],values[j+1][0]]);
	arrayAll.push([values[j][1],values[j+1][1]]);*/
	//获取数组内的个数-1，进行循环
	for(var j = 0;j<values.length-1;j++){
		//arrayAll.push(arrayAll,values[j]);
		//获取input相同类型个数，进行循环控制
		for(var n = 0;n<inputs.length;n++){
			
			arrayAll.push([values[j][n],values[j+1][n],values[j+2][n]]);
			
			}
	}
		
	console.log(arrayAll);
	//return arrayAll;
		
}