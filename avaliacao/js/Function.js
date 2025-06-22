function loadPage(tipoAvali)
{
	if(tipoAvali == "teste" || tipoAvali == "avaliacao")
		var result = doInitialize();
}

function unloadPage()
{
  	if (exitPageStatus != true)
 	{
		
		exitPageStatus = true;

		if(sco_passed != true)
		{
			doSetValue( "cmi.success_status", "failed" );
		}
		var result = doTerminate();
   	}
}

function quizScore(habil)
{
	if (exitPageStatus != true)
	{
		alert("Sua habilidade é de "+ habil + " em uma escala de 0.1 a 0.5 ");
	}
	doSetValue( "cmi.score.scaled", habil );
	doSetValue( "cmi.score.raw", habil );
	
	if(habil > 0.3){
		doSetValue( "cmi.success_status", "passed");
	}else{
		doSetValue( "cmi.success_status", "failed");
	}
}

function quizHabil(habil)
{
	if (exitPageStatus != true)
	{
		alert("Sua habilidade é de "+ habil + " em uma escala de 0.1 a 0.5 ");
	}
		
}

function verificarNavegador($id)
{
	if (navigator.appName.indexOf("Microsoft") != -1)
	{
		return window[$id];
	}
	else
	{
		return document[$id];
	}
}

function docontinue()
{
	doSetValue( "cmi.success_status", "passed" );
	doSetValue("adl.nav.request", "continue");
	doSetValue( "cmi.completion_status", "completed" );
	doSetValue( "cmi.exit", "" );
	sco_passed = true;
	unloadPage();
}

function doprevious()
{   
	doSetValue( "adl.nav.request", "previous" );
	doSetValue( "cmi.completion_status", "completed" );
	doSetValue( "cmi.exit", "" );
	unloadPage();
}

function dofinish()
{
	doSetValue( "adl.nav.request", "_none_" ); //adicionado pra terminar os testes
	doSetValue( "cmi.completion_status", "completed" );
	doSetValue( "cmi.exit", "" );
	sco_passed = true;
	unloadPage();

}

function dosatisfied()
{
	doSetValue( "adl.nav.request", "_none_" ); //adicionado pra terminar os testes
	doSetValue( "cmi.completion_status", "completed" );
	doSetValue( "cmi.exit", "" );
	unloadPage();
}