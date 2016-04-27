#!/bin/sh

CWD=$(pwd)

echo $CWD

rm -rf $CWD/build

mkdir $CWD/build

BDIR=$CWD/build

cd  $CWD/com_rrlogin/

zip $BDIR/com_rrlogin.zip *


cd  $CWD/mod_rrlogin/

zip $BDIR/mod_rrlogin.zip *

cd  $CWD/libraries/rrlogin/

zip $BDIR/lib_rrlogin_oauth.zip *

cd  $CWD/libraries/amcharts/

zip $BDIR/lib_amcharts.zip *

cd  $CWD/plugins/user/rrlogin/

zip $BDIR/plg_rrlogin.zip *     

cd  $CWD/plugins/rrlogin_integration/profile/

zip $BDIR/plg_rrlogin_profile.zip * 

cd  $CWD/plugins/authentication/rrlogin

zip $BDIR/plg_authentication_rrlogin.zip *

cd  $CWD/plugins/rrlogin_auth/rrnetwork

zip $BDIR/plg_RL_rrnetwork.zip *

cd $CWD

cp pkg_rrlogin.xml $BDIR/
cp script.php $BDIR/
cd $BDIR

zip pkg_rrlogin.zip *
