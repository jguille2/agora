<?PHP // $Id$ 
      // install.php - created with Moodle 2.0 dev (Build: 20090604) (2009060200)


$string['admindirerror'] = '지정한 관리 디렉토리가 적절치 않음';
$string['admindirname'] = '관리 디렉토리';
$string['admindirsetting'] = '간혹 어떤 웹호스트 업체는 제어판 등을 제공하는 특별한 URL으로서 /admin을 사용합니다. 불행하게도 이것은 무들 관리페이지를 위한 표준 위치와 충돌을 일으킵니다. 설치과정에서 관리 디렉토리의 이름을 바꿈으로서 이 문제를 고칠수 있는 데, 다음의 예와 같이 새이름을 여기에 넣으면 됩니다. 예: <br /> <br /><b>moodleadmin</b><br /> <br /> 이렇게 하면 무들에서 관리자 링크문제가 해결됩니다.';
$string['admindirsettinghead'] = '관리자 디렉토리 설정 ...';
$string['admindirsettingsub'] = '간혹 어떤 웹호스트 업체는 제어판 등을 제공하는 특별한 URL으로서 /admin을 사용합니다. 불행하게도 이것은 무들 관리페이지를 위한 표준 위치와 충돌을 일으킵니다. 설치과정에서 관리 디렉토리의 이름을 바꿈으로서 이 문제를 고칠수 있는 데, 다음의 예와 같이 새이름을 여기에 넣으면 됩니다. 예: <br /> <br /><b>moodleadmin</b><br /> <br /> 이렇게 하면 무들에서 관리자 링크문제가 해결됩니다.';
$string['availablelangs'] = '가능한 언어 목록';
$string['caution'] = '주의';
$string['chooselanguage'] = '언어를 선택하시오';
$string['chooselanguagehead'] = '언어를 선택하시오';
$string['chooselanguagesub'] = '설치 과정에서 사용할 언어를 선택하십시오. 선택한 언어는 사이트의 기본 언어로 사용할 수 있으며, 추후 다른 언어로 바꿀 수도 있습니다.';
$string['cliadminpassword'] = '새 관리자 암호';
$string['clialreadyinstalled'] = '이미 config.php 파일이 존재함. 사이트를 갱신하려면 admin/cli/upgrade.php를 사용하십시오';
$string['cliinstallfinished'] = '성공적으로 설치 완료';
$string['cliinstallheader'] = '무들 $a 명령 입력 설치 프로그램';
$string['climustagreelicense'] = '자동모드가 아닌 상태에서는  --agree-license 옵션을 이용하여 저작권을 승인하여야 함';
$string['clitablesexist'] = '데이터베이스가 이미 존재하므로 클라이언트의 설치를 계속할 수 없음';
$string['compatibilitysettings'] = 'PHP 설정을 검사하는 중 ..';
$string['compatibilitysettingshead'] = 'PHP 설정을 검사하는 중 ..';
$string['compatibilitysettingssub'] = '당신의 서버는 무들을 잘 작동시키기 위한 모든 테스트를 통과해야 합니다.';
$string['configfilenotwritten'] = '아마도 무들 경로가 쓰기 허용이 되어 있지 않아서, 설치 스크립트가 선택한 설정으로 config.php파일을 자동적으로 생성할 수 없었습니다. 직접 다음의 코드를 무들의 루트디렉토리 안의 config.php파일로 복사해 넣을 수는 있습니다.';
$string['configfilewritten'] = '성공적으로 contig.php가 생성되었음';
$string['configurationcomplete'] = '초기 설정 완료';
$string['configurationcompletehead'] = '초기 설정 완료';
$string['configurationcompletesub'] = '무들이 설치 루트디렉토리에 있는 파일에 당신의 설정을 저장하도록 시도하였습니다.';
$string['database'] = '데이타 베이스';
$string['databasecreationsettings'] = '이제 모든 무들 데이터가 저장될 데이터베이스를 설정할 필요가 있습니다. 이 데이터베이스는 아래에 지정된 설정 내용으로 무들 프로그램에 의해 자동설치 될 것입니다.<br /> <br /> <br /> <b>종류:</b> 설치프로그램에 의해 \"mysql\" 로 고정됨 <br /> <b>호스트:</b> 설치프로그램에 의해 \"localhost\"로 고정됨<br /> <b>이름:</b> 데이터베이스 이름, 예: moodle<br /> <b>사용자:</b> 설치프로그램에 의해 \"root\" 로 고정됨 <br /> <b>암호:</b> 데이터베이스 암호 <br /> <b>테이블 접두어:</b> 모든 테이블에 사용할 선택적 접두어';
$string['databasecreationsettingshead'] = '대부분의 무들 데이터가 저장될 데이터베이스를 설정해야 합니다. 설치프로그램에 의해 자동으로 아래에 명시된 설정대로 데이터베이스가 생성될 것입니다.';
$string['databasecreationsettingssub'] = '<b>종류:</b> 설치프로그램에 의해 \"mysql\" 로 고정됨 <br />
<b>호스트:</b>설치프로그램에 의해 \"localhost\"로 고정됨<br />
<b>이름:</b>데이터베이스이름, 예:moodle<br />
<b>사용자:</b> 설치프로그램에 의해 \"root\" 로 고정됨 <br />
<b>암호:</b> 데이터베이스 암호 <br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 선택적 접두어';
$string['databasecreationsettingssub2'] = '<b>종류:</b> 설치프로그램에 의해 \"mysqli\" 로 고정됨 <br />
<b>호스트:</b>설치프로그램에 의해 \"localhost\"로 고정됨<br />
<b>이름:</b>데이터베이스이름, 예:moodle<br />
<b>사용자:</b> 설치프로그램에 의해 \"root\" 로 고정됨 <br />
<b>암호:</b> 데이터베이스 암호 <br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 선택적 접두어';
$string['databasehead'] = '데이터베이스 설정';
$string['databasehost'] = '데이터베이스 호스트 :';
$string['databasename'] = '데이터베이스 명칭 :';
$string['databasepass'] = '데이터베이스 비밀번호 :';
$string['databasesettings'] = '지금 대부분의 무들 정보가 저장될 데이터베이스를 설정할 필요가 있습니다. 이 데이터베이스는 미리 생성되어 있어야 하며, 데이터베이스에 접근하기위한 사용자명과 비밀번호가 등록되어 있어야만 합니다.<br />
<br /> <br />
<b>종류:</b> mysql 또는 postgres7<br />
<b>호스트:</b>예: localhost 또는 db.isp.com <br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 선택적 접두어';
$string['databasesettingshead'] = '모든 무들데이터가 저장되는 데이터베이스를 설정할 필요가 있습니다. 이 데이터베이스는 이미 만들어졌으며 이에 접근할 수 있는 사용자명과 암호가 등록되어 있어야만 합니다.';
$string['databasesettingssub'] = '<b>종류:</b> mysql 또는 postgres7<br />
<b>호스트:</b>예: localhost 또는 db.isp.com <br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 선택적 접두어';
$string['databasesettingssub_mssql'] = '<b>종류:</b> SQL*Server (non UTF-8) <b><font color=\"red\">실험적임! (현재 운영되고 있는 사이트에서는 쓰지 마시오.)</font></b><br />
<b>호스트:</b>예: localhost 또는 db.isp.com <br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어 (필수)';
$string['databasesettingssub_mssql_n'] = '<b>종류:</b> SQL*Server (UTF-8 설정)<br />
<b>호스트:</b>예: localhost 또는 db.isp.com <br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어(필수)';
$string['databasesettingssub_mysql'] = '<b>종류:</b> MySQL<br />
<b>호스트:</b>예: localhost 또는 db.isp.com <br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어(선택사항)';
$string['databasesettingssub_mysqli'] = '<b>종류:</b>향상된 MySQL<br />
<b>호스트:</b>예: localhost 또는 db.isp.com <br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어(선택사항)';
$string['databasesettingssub_oci8po'] = '<b>종류:</b>  Oracle<br />
<b>호스트:</b> 사용되지 않음, 공백이어야 함<br />
<b>이름:</b> tnsnames.ora 접속에 쓰는 이름<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어(필수, 2cc. max)';
$string['databasesettingssub_odbc_mssql'] = '<b>종류:</b> SQL*Server (over ODBC) <b>Experimental!</b><br />
<b>호스트:</b>ODBC조절패널의 DSN에서 부여한 이름<br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어(필수)';
$string['databasesettingssub_postgres7'] = '<b>종류:</b>  포스트그레SQL<br />
<b>호스트:</b>예: localhost 또는 db.isp.com <br />
<b>이름:</b> 데이터베이스 이름, 예:moodle<br />
<b>사용자:</b> 데이터베이스 사용자명<br />
<b>암호:</b> 데이터베이스 암호<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어 (필수)';
$string['databasesettingswillbecreated'] = '<b>알림:</b>만일 데이터베이스가 없다면 인스톨러가 데이터베이스를 만들려고 할 것입니다.';
$string['databasesocket'] = '유닉스 소켓';
$string['databasetypehead'] = '데이터베이스 드라이버 선택';
$string['databasetypesub'] = '무들은 여러 종류의 데이터베이스 서버를 지원합니다. 어떤 서버를 사용해야 할 지 모르겠다면 서버 관리자에게 문의하기 바랍니다.';
$string['databaseuser'] = '데이터베이스 사용자명 :';
$string['dataroot'] = '데이타 경로';
$string['datarooterror'] = '지정한 \'데이타 경로\'가 없거나 생성되지 않았습니다. 정확한 경로로 고치거나 수동으로 그 디렉토리를 생성해 놓으십시오.';
$string['datarootpublicerror'] = '지정한 \'데이타 경로\'는 직접 웹으로 접근할 수 있기 때문에, 다른 경로를 지정해야만 합니다.';
$string['dbconnectionerror'] = '지정한 데이터베이스에 연결할 수 없습니다. 데이타베이스의 설정을 점검하시오.';
$string['dbcreationerror'] = '데이터베이스 생성 오류. 주어진 사용자명 및 암호로 사용할 데이터베이스를 생성할 수 없음';
$string['dbhost'] = '호스트 서버';
$string['dbpass'] = '비밀번호';
$string['dbprefix'] = '테이블 접두어';
$string['dbtype'] = '형태';
$string['dbwrongencoding'] = '선택된 데이터베이스는 바람직하지 않은 인코딩 방법($a)에 의해 동작하고 있습니다. 유니코드 (UTF-8)로 인코딩 되는 데이터베이스를 사용하는 것이 좋습니다. 아래의\"DB 인코딩 테스트 건너뛰기\"를 선택하여 이 테스트를 건너뛸 수 있지만 추후에 문제가 야기될 수 있습니다.';
$string['dbwronghostserver'] = '이미 설명한 \"호스트\"의 규칙을 따라야만 합니다.';
$string['dbwrongnlslang'] = '웹서버의 NLS_LANG 환경 변수들은 AL32UTF8 문자셋으로 작성되어야만 합니다. OCI8을 적절하게 설정하기 위한 PHP 문서를 참조하십시오.';
$string['dbwrongprefix'] = '위에 설명한 대로 \"테이블 접두어\" 규칙을 따라야만 합니다.';
$string['directorysettings'] = '<p>무들을 설치할 위치를 확인하세요.</p>

<p><b>웹주소:</b>
무들을 접속할 전체 웹 주소를 지정하세요. 만약 당신의 웹 사이트가 복합적인 URLs를 경유하여 접근가능하다면 학생들이 사용할 가장 자연스러운 것을 선택하세요. 마지막에 슬레시를 넣지 마세요.</p>

<p><b>무들 경로:</b>
완전한 디렉토리 경로를 명기하세요. 대소문자를 정확히 구별하여 기재하세요.</p>

<p><b>데이터 경로:</b>
무들로 업로드된 파일을 저장할 수 있는 장소가 필요합니다. 이 디렉토리는 웹 서버의 사용자(보통 \"none\" 또는 \"apache\" )에 의해서 \'읽고쓰기 가능\' 권한을 보유하여야 합니다. 그러나 직접적으로 웹을 통해 접근할 수 있어서는 안됩니다.</p>';
$string['directorysettingshead'] = '무들 설치 위치를 확인하기 바랍니다.';
$string['directorysettingssub'] = '<b>웹 주소:</b>
무들이 접속될 완전한 웹주소를 기입하시오.
만일 다중 URL을 통하여 웹사이트에 접근할 수 있다면 학습자가 사용할 자연스런 주소를 선택하시오. 끝에 슬래시를 포함하지 마십시요.
<br />
<br />
<b>무들 경로:</b>
완전한 디렉토리 경로를 명기하세요. 대소문자를 정확히 구별하여 기재하세요.
<br />
<br />
<b>데이터 디렉토리:</b>
무들로 업로드된 파일을 저장할 수 있는 장소가 필요합니다. 이 디렉토리는 웹 서버의 사용자(보통 \"none\" 또는 \"apache\" )에 의해서 \'읽고쓰기 가능\' 권한을 보유하여야 합니다. 그러나 직접적으로 웹을 통해 접근할 수 있어서는 안됩니다.';
$string['dirroot'] = '무들 디렉토리';
$string['dirrooterror'] = '무들의 경로가 바르지 않은 것 같습니다 - 무들의 설치 프로그램을 찾을 수 없습니다. 아래의 값들은 초기화 되었습니다.';
$string['download'] = '내려 받음';
$string['downloadlanguagebutton'] = '\"$a\" 언어팩 내려받기';
$string['downloadlanguagehead'] = '언어팩 다운로드';
$string['downloadlanguagenotneeded'] = '기본 언어팩인 \"$a\"을 사용하여 설치과정을 계속할 수 있습니다.';
$string['downloadlanguagesub'] = '이제 언어팩 선택을 하셨기 때문에 추후에는 지정한 언어로 설치가 계속될 것있니다.<br /><br />만일 해당 언어팩을 내려받지 못한다면, 영문으로 설치가 계속될 것입니다.(일단 영문으로 프로그램을 깐 후, 다시 또 다른 언어팩을 선택하여 설정할 수 있는 기회가 있습니다)';
$string['doyouagree'] = '동의하십니까? (yes/no) :';
$string['environmenthead'] = '구동환경을 점검합니다...';
$string['environmentsub'] = '기존 운영체제가 무들의 여러 구성 요소들을 구동하는데 적합한지 점검합니다.';
$string['environmentsub2'] = '개개의 무들 배포본은 필요로하는 최소한의 PHP 버전과 확장기능이 다릅니다. 각 판을 설치하거나 판올림하기 전에 완벽한 구동환경을 점검해야 합니다. 혹 여러분이 어떻게 새 판을 설치해야 할지 또 어떻게 PHP 확장 기능을 설치해야 할지 모르겠다면, 서버 관리자에게 문의하기 바랍니다.';
$string['errorsinenvironment'] = '환경설정에 오류가 있습니다!';
$string['fail'] = '실패';
$string['fileuploads'] = '파일 올리기';
$string['fileuploadserror'] = '이것은 켜져야 합니다.';
$string['fileuploadshelp'] = '<p>서버로 파일올리기가 불가능해 보입니다.</p>

<p>무들은 설치될 수 있지만 파일을 업로딩 할 수 없는 상태에서는 강좌에 파일이나 사진을 올릴 수 없을 것입니다.</p>

<p>파일 업로딩이 가능하게 하기 위해서는 당신(또는 당신의 시스템 관리자)가 php.ini 파일 속의  <b>file_upload</b>을 \'1\'로 설정해야 할 것입니다.</p>';
$string['gdversion'] = 'GD 의 버전';
$string['gdversionerror'] = '사진이나 그림을 처리하기 위해서 필수적으로 GD 라이브러리가 있어야만 함';
$string['gdversionhelp'] = '<P>서버에 GD라이브러리가 설치되지 않은 것 같습니다.

<P>GD는 무들이 (사용자 아이콘과 같은) 그림이나 (함수 그래프와 같은) 새로운 이미지를 생성,처리할 수 있도록 PHP에 의해서 요구되는 라이브러리 입니다. 하지만 무들은 GD없이도 작동되는데, 이 때는 GD가 제공하는 기능은 사용할 수 없을 것입니다.';
$string['globalsquotes'] = '전역변수 조작 안전성 결여';
$string['globalsquoteserror'] = 'PHP.ini 속의 설정을 다음과 같이 고치십시오:  register_globals 및 enable magic_quotes_gpc 을 끄십시오(Off).';
$string['globalsquoteshelp'] = '<p>magic_quotes_gpc = Off 과 register_globals = On 을 같이 쓰는 것은 바람직하지 않습니다.</p>

<p>권장하는 php.ini 설정은 <b>magic_quotes_gpc = On</b> 과 <b>register_globals = Off</b> 입니다.</p>

<p>만일 여러분이 php.ini 에 접근할 수 없다면, 무들 디렉토리안에 아래의 내용이 담긴 .htaccess 파일을 넣어 두십시오.
<blockquote>php_value magic_quotes_gpc On</blockquote>
<blockquote>php_value register_globals Off</blockquote>
</p>';
$string['inputdatadirectory'] = '데이터 경로 :';
$string['inputwebadress'] = '웹 주소 :';
$string['inputwebdirectory'] = '무들 경로 :';
$string['installation'] = '설치';
$string['langdownloaderror'] = '안타깝게도 \"$a\" 언어팩이 설치되지 않았습니다. 대신 영어를 이용하여 설치될 것입니다.';
$string['langdownloadok'] = '\"$a\" 언어팩이 성공적으로 설치되었습니다. 해당 언어를 이용하여 설치가 진행될 것입니다.';
$string['magicquotesruntime'] = 'Magic Quotes 실행 시간';
$string['magicquotesruntimeerror'] = '이것은 꺼져야 합니다.';
$string['magicquotesruntimehelp'] = '<p>Magic quotes runtime은 무들이 제대로 작동하기 위해 꺼져야(Off) 합니다.</p>

<p>일반적으로 기본값은 Off 입니다만 다시한번 php.ini파일에 있는 <b>magic_quotes_runtime</b>을 확인해 보세요.</p>

<p>만약에 당신이 php.ini파일에 접근하지 못한다면 무들 디렉토리안에 다음의 내용을 적은 .htaccess 파일을 넣어두기 바랍니다.</p>
<blockquote><div>php_value magic_quotes_runtime Off</div></blockquote>';
$string['memorylimit'] = '메모리 사용량';
$string['memorylimiterror'] = 'php의 메모리 사용량이 너무 작게 설정되어 있습니다. 당신은 후에 문제에 봉착할 지도 모릅니다.';
$string['memorylimithelp'] = '<p>현재 서버의 PHP 메모리 사용량은 $a 로 설정되어 있습니다.</p>

<p>이는 추후에 무들이 원활히 구동되는 데 문제가 될 것입니다. 특히 여러분이 상당히 많은 모듈을 이용하고 또 사용자가 많아지게 되면 문제가 될 소지가 더 커집니다.</p>

<p>PHP가 사용할 수 있는 메모리 용랑을 40M 나 아니면 더 큰 값으로 설정하길 권합니다. 설정하는 방법은 
여러가지가 있습니다.</p>
<ol>
<li>만약 PHP소스를 재컴파일 할 수 있다면 옵션에 <i>--enable-memory-limit</i> 을 포함시켜 컴파일 하십시오. 이렇게 해 놓으면 무들 프로그램으로 메모리 용량을 제어할 수 있게 됩니다.</li>

<li>만약 php.ini 파일에 접근 가능하다면 당신은 <b>memory_limit 40M</b> 처럼 값을 바꿀 수 있을것입니다. 만약 여러분이 직접 접근 할 수 없다면 서버 관리자에게 요청하여 처리하실 수 있습니다.</li>

<li>또 도저히 php.ini 안에 있는 값을 바꿀 수가 없다면 무들 디렉토리에 아래와 같은 내용을 포함하는 .htaccess 를 넣어두면 됩니다.
<P><blockquote>php_value memory_limit 40M<blockquote></p>
<p>그러나 어떤 서버에서는 이러한 기능이 모든 PHP페이지에 적용되어 버릴 수도 있게 되는 데 (당신이 페이지를 살펴보았을때 문제를 찾을 것이다) 이 때에는 .htaccess 를 제거해야 하고 다른 방안을 찾아봐야 할 것입니다.</p></li></ol>';
$string['mssql'] = 'SQL* 서버 (mssql)';
$string['mssql_n'] = 'UTF-8을 지원하는 SQL* 서버 (mssql_n)';
$string['mssqlextensionisnotpresentinphp'] = 'MSSQL확장자를 이용해 SQL*서버와 연동할 수 있도록 적절하게 설정되지 못했습니다. php.ini 파일을 점검해 보거나 PHP를 다시 컴파일 하십시오.';
$string['mysql'] = 'MySQL (mysql)';
$string['mysqlextensionisnotpresentinphp'] = 'MySQL확장자를 이용해 서버와 연동할 수 있도록 적절하게 설정되지 못했습니다. php.ini 파일을 점검해 보거나 PHP를 다시 컴파일 하십시오.';
$string['mysqli'] = '향상된 MySQL (mysqli)';
$string['mysqliextensionisnotpresentinphp'] = 'PHP가 MySQLi확장자를 이용해 서버와 연동할 수 있도록 적절하게 설정되지 못해서 MySQL로 통신하게 되었습니다. php.ini 파일을 점검해 보거나 PHP를 다시 컴파일 하십시오.  MySQLi 확장자는 PHP 4에는 사용할 수 없습니다.';
$string['nativemysqli'] = '향상된 MySQL (원본/mysqli)';
$string['nativemysqlihelp'] = '이제 대부분의 무들 자료가 저장될 데이터베이스를 설정해야 합니다. 이미 데이터베이스에 관련된 사용자명, 비밀번호 및 허가권을 가지고 있다면 데이터베이스가 생성될 수 있을 것입니다. 테이블의 접두어는 선택사항입니다.';
$string['nativeoci'] = '오라클 (원본/oci)';
$string['nativepgsql'] = '포스트그레SQL (원본/pgsql)';
$string['nativepgsqlhelp'] = '이제 대부분의 무들 자료가 저장될 데이터베이스를 설정해야 합니다. 이 데이터베이스는 미리 생성되어 있어야 하며 사용자명과 비밀번호는 데이터베이스에 접속하는데 이용될 것입니다. 테이블 접두어는 필수입니다.';
$string['oci8po'] = '오라클 (oci8po)';
$string['ociextensionisnotpresentinphp'] = 'OCI8 익스텐션으로 PHP가 오라클서버와 통신하도록 적절히 설정되지 않았습니다. php.ini 파일을 점검하거나 PHP를 다시 컴파일 하십시오.';
$string['odbc_mssql'] = 'ODBC를 통한 SQL*Server (odbc_mssql)';
$string['odbcextensionisnotpresentinphp'] = 'ODBC 익스텐션으로 PHP가 SQL*서버와 통신하도록 적절히 설정되지 않았습니다. php.ini 파일을 점검하거나 PHP를 다시 컴파일 하십시오.';
$string['pass'] = '통과';
$string['paths'] = '경로';
$string['pathserrcreatedataroot'] = '설치 스크립트가 자료 디렉토리 ($a->dataroot) 를 생성할 수 없습니다.';
$string['pathshead'] = '경로 확인';
$string['pathsrodataroot'] = 'Dataroot 디렉토리의 쓰기허가권이 없습니다.';
$string['pathsroparentdataroot'] = '상위 경로 ($a->parent) 에 쓰기허가권이 없습니다. 설치 스크립트가 자료 디렉토리 ($a->dataroot) 를 생성할 수 없습니다.';
$string['pathssubadmindir'] = '간혹 어떤 웹호스트 업체는 제어판 등을 제공하는 특별한 URL으로서 /admin을 사용합니다. 불행하게도 이것은 무들 관리페이지를 위한 표준 위치와 충돌을 일으킵니다. 설치과정에서 관리 디렉토리의 이름을 바꿈으로서 이 문제를 고칠수 있는 데, 다음의 예와 같이 새이름을 여기에 넣으면 됩니다. 예: <em>moodleadmin</em> 이렇게 하면 무들에서 관리자 링크문제가 해결됩니다.';
$string['pathssubdataroot'] = '무들로 업로드된 파일을 저장할 수 있는 장소가 필요합니다. 이 디렉토리는 웹 서버의 사용자(보통 \"none\" 또는 \"apache\" )에 의해서 \'읽고쓰기 가능\' 권한을 보유하여야 합니다. 그러나 직접적으로 웹을 경유해서 접근할 수 있어서는 안됩니다.';
$string['pathssubdirroot'] = '무들 설치를 위한 완전한 디렉토리 경로. 심볼릭 링크를 사용하기 위해 꼭 필요한 경우 변경';
$string['pathssubwwwroot'] = '무들을 접속할 수 있는 전체 웹 주소. 다중 주소를 이용해서는 무들에 접속할 수 없음.
만일 사이트가 복수의 공개 주소를 갖고 있는 경우, 여기에 입력한 주소 이외의 곳에서는 영구적인 redirect를 설정해 놓아야만 함.
만약 여러분의 사이트를 인터넷과 인트라넷 모두에서 접속할 수 있게 하려면 여기에 공식적인 주소를 입력하고 DNS를 설정해서 인트라넷 사용자들도 공개 주소를 사용할 수 있게 해야할 것입니다.';
$string['pathsunsecuredataroot'] = 'Dataroot 경로가 안전하지 않음';
$string['pathswrongadmindir'] = '관리자 경로가 존재하지 않음';
$string['pathswrongdirroot'] = '잘못된 dirroot 위치';
$string['pgsqlextensionisnotpresentinphp'] = 'PGSQL 익스텐션으로 PHP가 포스트그레SQL 서버와 통신하도록 적절히 설정되지 않았습니다. php.ini 파일을 점검하거나 PHP를 다시 컴파일 하십시오.';
$string['phpextension'] = '$a PHP 확장';
$string['phpversion'] = 'php버젼';
$string['phpversionhelp'] = '<p>무들은 적어도 PHP4.3.0 혹은 5.1.0. 이상 이어야합니다.(5.0.x는 버그가 있다고 알려져 있습니다)</p>
<p>현재 구동되고 있는 PHP버전은 $a 입니다.</p>
<p>PHP를 업그레이드 하시거나 새버전을 제공하는 웹호스팅 업체로 이전하기를 권합니다!<br />(만일 5.0.x버전을 사용 중이라면 4.4.x 버전으로 다운그레이드 할 수 있습니다)</p>';
$string['postgres7'] = '포스트그레SQL (postgres7)';
$string['releasenoteslink'] = '본 무들판에 대한 좀 더 자세한 내용을 알고 싶으면, $a 에 있는 개정 안내(Release Notes)를 참조하기 바랍니다.';
$string['safemode'] = '안전모드';
$string['safemodeerror'] = '아마 안전모드(Safe Mode)가 작동되어서 문제가 생겼을 것입니다.';
$string['safemodehelp'] = '<p>무들은 safe mode on 상태에서는 작동이 원활하지 않을 텐데, 아마 그 중 하나가 새로운 파일을 못 만들게 하는 문제일 것입니다.</p>
<p>Safe mode는 일단의 보안 편집증적인 웹호스트에서 이를 켜 놓을 것인데, 무들 사이트를 원활히 운용하기 위해서는 새로운 웹호스트를 찾아보시는 편이 나을 겁니다.</p>
<p>원한다면 설치는 계속할 수는 있는데, 나중에 문제에 봉착할 것이라는 점을 염두에 두기 바랍니다.</p>';
$string['sessionautostart'] = '세션 자동 시작';
$string['sessionautostarterror'] = '이것은 꺼져 있어야(Off) 합니다.';
$string['sessionautostarthelp'] = '<p>무들은 세션의 지원이 필요하고 그것 없이는 작동하지 않을 것 입니다.</p>
<P>세션은 php.ini 파일 안에서 조정될 수 있습니다. session.auto_start 항목을 살펴보세요.</p>';
$string['skipdbencodingtest'] = 'DB 엔코딩 테스트 생략';
$string['sqliteextensionisnotpresentinphp'] = 'PHP가 SQLite 확장에 걸맞게 설정되지 않았습니다. php.ini 파일을 점검해 보거나 PHP를 다시 컴파일 하시기 바랍니다.';
$string['upgradingqtypeplugin'] = '문항/유형 플러그인 갱신';
$string['welcomep10'] = '$a->installername ($a->installerversion)';
$string['welcomep20'] = '당신의 컴퓨터에 <strong>$a->packname $a->packversion</strong> 패키지를 성공적으로 설치한 것을 축하합니다!';
$string['welcomep30'] = '<strong>$a->installername</strong> 의 이 릴리스는 <strong>무들</strong>이 그 속에서 동작하는 환경을 생성하기 위한 어플리케이션을 포함하고 있습니다.';
$string['welcomep40'] = '이 패키지는 <strong>무들 $a->moodlerelease ($a->moodleversion)</strong> 을 포함하고 있습니다.';
$string['welcomep50'] = '이 패키지에 있는 모든 어플리케이션을 사용하는 것은 각각의 라이센스에의해 지배받습니다. 완전한<strong>$a->installername</strong> 패키지는
<a href=\"http://www.opensource.org/docs/definition_plain.html\">공개 소스이며 </a> <a href=\"http://www.gnu.org/copyleft/gpl.html\">GPL</a> 라이선스에 의해 배포됩니다.';
$string['welcomep60'] = '다음 화면들은 당신의 컴퓨터에 <strong>무들</strong>을 설정하고 설치하는 길라잡이 역할을 할 것입니다. 기본 설정을 선택하거나 목적에 맞게 선택적으로 수정할 수 있습니다.';
$string['welcomep70'] = '<strong>무들</strong> 설정을 계속하기 위해서는 \"다음\" 버튼을 클릭하세요.';
$string['wwwroot'] = '웹 주소';
$string['wwwrooterror'] = '이 웹 주소는 유효한 것 같지 않습니다 - 무들 설치 프로그램이 거기에 없습니다. 아래의 값들은 초기화되었습니다.';
$string['aborting'] = '설치 취소'; // ORPHANED
$string['adminemail'] = '이메일 :'; // ORPHANED
$string['adminfirstname'] = '이름 :'; // ORPHANED
$string['admininfo'] = '관리자 정보'; // ORPHANED
$string['adminlastname'] = '성 :'; // ORPHANED
$string['adminpassword'] = '비밀번호 :'; // ORPHANED
$string['adminusername'] = '사용자 ID :'; // ORPHANED
$string['askcontinue'] = '계속할까요 (yes/no) :'; // ORPHANED
$string['availabledbtypes'] = '사용가능한 디비 유형'; // ORPHANED
$string['cannotconnecttodb'] = '디비에 연결할 수 없음'; // ORPHANED
$string['checkingphpsettings'] = 'PHP설정 점검'; // ORPHANED
$string['configfilecreated'] = '설정파일 생성 완료'; // ORPHANED
$string['configfiledoesnotexist'] = '설정파일이 존재하지 않습니다!!!'; // ORPHANED
$string['configurationfileexist'] = '이미 설정파일이 존재합니다!'; // ORPHANED
$string['creatingconfigfile'] = '설정파일 작성 중...'; // ORPHANED
$string['databasesettingsformoodle'] = '무들을 위한 데이터베이스 설정'; // ORPHANED
$string['databasetype'] = '데이터베이스 유형 :'; // ORPHANED
$string['disagreelicense'] = 'GPL 규약에 동의하지 않았으므로 갱신을 중단합니다!'; // ORPHANED
$string['downloadlanguagepack'] = '/n/n 언어팩을 내려받으시겠습니까?(yes/no) :'; // ORPHANED
$string['downloadsuccess'] = '언어팩 내려받기 성공'; // ORPHANED
$string['installationiscomplete'] = '설치 완료!'; // ORPHANED
$string['invalidargumenthelp'] = '오류 : 잘못된 인수< /br> 사용예 : \$ php cliupgrade.php OPTIONS< /br> 좀 더 자세한 내용은 --help 옵션을 사용'; // ORPHANED
$string['invalidemail'] = '잘못된 이메일주소'; // ORPHANED
$string['invalidhost'] = '잘못된 호스트'; // ORPHANED
$string['invalidint'] = '오류 : 정수값이 아님'; // ORPHANED
$string['invalidintrange'] = '오류 : 범위를 벗어난 값'; // ORPHANED
$string['invalidpath'] = '잘못된 경로'; // ORPHANED
$string['invalidsetelement'] = '오류 : 주어진 옵션에 적절한 값이 아님'; // ORPHANED
$string['invalidtextvalue'] = '잘못된 문자값'; // ORPHANED
$string['invalidurl'] = '잘못된 웹주소'; // ORPHANED
$string['invalidvalueforlanguage'] = '--lang 옵션에 맞지 않는 값. 좀 더 자세한 내용은 --help 옵션을 사용'; // ORPHANED
$string['invalidyesno'] = '오류 : yes/no에 적절하지 않은 인수'; // ORPHANED
$string['locationanddirectories'] = '위치 및 경로'; // ORPHANED
$string['pdosqlite3'] = 'SQLite 3 (PDO) <b><strong class=\"errormsg\">실험적임! (상용서버에서는 사용하지 말 것)</strong></b>'; // ORPHANED
$string['php52versionerror'] = 'PHP는 최소한 5.2.4 이상이어야 합니다.'; // ORPHANED
$string['php52versionhelp'] = '<p>무들은 최소한 PHP 5.2.4 이상을 요구합니다..</p>
<p>현재 구동되고 있는 판은 $a 입니다.</p>
<p>PHP를 판올림하던가 새 판을 지원하는 호스트로 이전해야 합니다!</p>'; // ORPHANED
$string['selectlanguage'] = '설치를 위한 언어 선택'; // ORPHANED
$string['sitefullname'] = '사이트명칭 :'; // ORPHANED
$string['siteinfo'] = '사이트 소개'; // ORPHANED
$string['sitenewsitems'] = '새소식 항목 :'; // ORPHANED
$string['siteshortname'] = '사이트 단축명 :'; // ORPHANED
$string['sitesummary'] = '사이트 개요 :'; // ORPHANED
$string['tableprefix'] = '테이블 접두어 :'; // ORPHANED
$string['upgradingactivitymodule'] = '활동 모듈 갱신'; // ORPHANED
$string['upgradingbackupdb'] = '백업 데이터베이스 갱신'; // ORPHANED
$string['upgradingblocksdb'] = '블럭 데이터베이스 갱신'; // ORPHANED
$string['upgradingblocksplugin'] = '블럭 플러그인 갱신'; // ORPHANED
$string['upgradingcompleted'] = '갱신 완료 ...'; // ORPHANED
$string['upgradingcourseformatplugin'] = '강좌 포맷 플러그인 갱신'; // ORPHANED
$string['upgradingenrolplugin'] = '출석 플러그인 갱신'; // ORPHANED
$string['upgradinggradeexportplugin'] = '성적 내보내기 플러그인 갱신'; // ORPHANED
$string['upgradinggradeimportplugin'] = '성적 불러들이기 플러그인 갱신'; // ORPHANED
$string['upgradinggradereportplugin'] = '성적표 작성 플러그인 갱신'; // ORPHANED
$string['upgradinglocaldb'] = '로칼 데이터베이스 갱신'; // ORPHANED
$string['upgradingmessageoutputpluggin'] = '메시지 송출 플러그인 갱신'; // ORPHANED
$string['upgradingrpcfunctions'] = 'RPC 기능 갱신'; // ORPHANED
$string['usagehelp'] = '개괄:
$php cliupgrade.php OPTIONS /n
옵션
--lang 설치를 위한 준비된 언어. 기본값은 영어(en)
--webaddr 무들 사이트를 위한 웹 주소
--moodledir 무들 웹 경로 위치
--datadir 무들 자료 경로(data folder) 위치(웹에서 보이지 않아야 함)
--dbtype 데이터베이스 유형. 기본값은 mysql
--dbhost 데이터베이스 호스트. 기본값은 localhost
--dbname 데이터베이스명. 기본값은 moodle
--dbuser 데이터베이스 사용자. 기본값은 공난
--dbpass 데이터베이스 암호. 기본값은 공난
--prefix 상기 데이터베이스의 테이블 접두어. 기본값은 mdl
--verbose 0 출력없음, 1 요약 출력(기본값), 2 상세 출력
--interactivelevel 0 Non interactive, 1 semi interactive(Default), 2 interactive
--agreelicense Yes(기본값) 혹은 No
--confirmrelease Yes(기본값) 혹은 No
--sitefullname 사이트 전체 이름. 기본값은 : Moodle Site (사이트명을 바꾸세요!!)
--siteshortname 사이트 단축명. 기본값은 moodle
--sitesummary 사이트 개요. 기본값은 공난
--adminfirstname 관리자 이름. 기본값은 Admin
--adminlastname 관리자의 성. 기본값은 User
--adminusername 관리자 ID. 기본값은 admin
--adminpassword 관리자 암호. 기본값은 admin
--adminemail 관리자 이메일. 기본값은 root@localhost
--help 본 도움말 출력 /n

사용예시:
$php cliupgrade.php --lang=en --webaddr=http://www.example.com --moodledir=/var/www/html/moodle --datadir=/var/moodledata --dbtype=mysql --dbhost=localhost --dbname=moodle --dbuser=root --prefix=mdl --agreelicense=yes --confirmrelease=yes --sitefullname=\"Example Moodle Site\" --siteshortname=moodle --sitesummary=siteforme --adminfirstname=Admin --adminlastname=User --adminusername=admin --adminpassword=admin --adminemail=admin@example.com --verbose=1 --interactivelevel=2'; // ORPHANED
$string['versionerror'] = '판오류로 인한 사용자 취소'; // ORPHANED
$string['welcometext'] = '--무들 설치를 위한 명령입력 모드입니다--'; // ORPHANED
$string['writetoconfigfilefaild'] = '오류 : 설정 파일 쓰기 실패'; // ORPHANED
$string['yourchoice'] = '선택 :'; // ORPHANED
$string['databasesettingssub_sqlite3_pdo'] = '<b>종류:</b>  SQLite 3 (PDO) <b><strong class=\"errormsg\">시험적임! (실제 상용으로는 사용하지 말 것)</strong></b><br />
<b>호스트:</b>데이터 베이스 파일이 저장될 경로(전체 경로명을 사용할 것); 무들의 데이터 디렉토리를 사용하려면 localhost 를 적거나 공백으로 둘 것<br />
<b>이름:</b> 데이터베이스 이름, 예:moodle (선택사항)<br />
<b>사용자:</b> 데이터베이스 사용자명 (선택사항)<br />
<b>암호:</b> 데이터베이스 암호 (선택사항)<br />
<b>테이블 접두어:</b> 모든 테이블에 사용할 접두어<br />데이터베이스 파일의 명칭은 앞에서 입력한 사용자명, 데이터베이스명 및 암호에 의해 결정될 것임.'; // ORPHANED
$string['sqlite3_pdo'] = 'SQLite 3 (PDO) <b><strong class=\"errormsg\">시험적임! (실제 상용으로는 사용하지 말 것)</strong></b>'; // ORPHANED
$string['phpversionerror'] = 'php 버젼은 최소한 4.3.0 혹은 5.1.0. 이상 이어야합니다.(5.0.x는 버그가 있다고 알려져 있습니다)'; // ORPHANED
$string['unsafedirname'] = '오류 : 경로명에 적절치 않은 문자 포함. 사용가능한 문자는 a-zA-Z0-9_- 입니다. /n'; // ORPHANED

?>
