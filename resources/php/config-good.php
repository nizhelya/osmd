<?php
$API = array(
'QueryForm'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>4
	  )
           
        )
    ),
'QueryAddress'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
	  )
           
        )
    ),
'QueryTekNach'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
	  ),
	      'delPokVodomer'=>array(
                'len'=>1
	  ),
	      'newPokVodomer'=>array(
                'len'=>1
	  )
           
        )
    ),
'QueryTarifTables'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )
            
        )
    ),

'QueryUserLogin'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),
              'registration'=>array(
                 'len'=> 1
                ),
             'login'=>array(
                 'len'=> 1
                ),
                'checkLogin'=>array(
                 'len'=> 1
                ),
		'checkMyFlat'=>array(
                 'len'=> 3
                ),
		'updateUser'=>array(
                 'len'=> 1
                )

        )
    ),
'QueryMyFlat'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),
            'createRecord'=>array(
            	'len'=>1
            ),
            'updateRecords'=>array(
            	'len'=>1
            ),
            'destroyRecord'=>array(
            	'len'=>1
            )
        )
    ),
'QueryVideo'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),
            'createRecord'=>array(
            	'len'=>1
            ),
            'updateRecords'=>array(
            	'len'=>1
            ),
            'destroyRecord'=>array(
            	'len'=>1
            )
        )
    ),
'QueryStatistika'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )        
        )
    ),
'QueryAdminPn'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),             
	    'saveComp'=>array(
                 'len'=> 1
                ),
	    'saveDept'=>array(
                 'len'=> 1
                ),
	    'addDept'=>array(
                 'len'=> 1
                ),
	    'deleteDept'=>array(
                 'len'=> 1
                ),
	    'savePers'=>array(
                 'len'=> 1
                ),
	    'addPers'=>array(
                 'len'=> 1
                ),
	    'deletePers'=>array(
                 'len'=> 1
                ),
	    'saveTel'=>array(
                 'len'=> 1
                ),
	    'addTel'=>array(
                 'len'=> 1
                ),
	    'deleteTel'=>array(
                 'len'=> 1
                )
	
        )
    ),
'QueryOrg'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )        
        )
    ),
'QueryCrudOrg'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>4
            ),
            'createRecord'=>array(
            	'len'=>4
            ),
            'updateRecords'=>array(
            	'len'=>4
            ),
            'destroyRecord'=>array(
            	'len'=>4
            )        
        )
    ),
'QueryLoad'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )        
        )
    )


);


