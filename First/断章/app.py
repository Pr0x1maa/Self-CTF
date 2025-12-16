from flask import Flask, request, jsonify, render_template, session, redirect, url_for, flash, get_flashed_messages
import pymysql
import os
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)

app.secret_key = os.urandom(24)

DB_HOST = '127.0.0.1'
DB_USER = 'Pr0x1ma'
DB_PASS = 'Th1s_1s_p233_wo2d'

DB_NAME_User = "Terra_User"
DB_NAME_Data = "Terra_Data"

def get_db_connection(db_name):
    return pymysql.connect(
        host = DB_HOST,
        user = DB_USER,
        password = DB_PASS,
        database = db_name,
        cursorclass = pymysql.cursors.DictCursor,
        autocommit = True
    )

def waf(input_str):
    blacklist = ['#', '-']
    for char in blacklist:
        if char in input_str:
            return None
    
    filter_list = ['select', 'or', 'and']

    input_str = input_str.lower()

    for keyword in filter_list:
        input_str = input_str.replace(keyword, "")

    return input_str


@app.route('/')
def index():
    if not session.get('logged_in'):
        return redirect(url_for('login'))
    return render_template('index.html')

@app.route('/register', methods=['GET', 'POST'])
def register():
    error = None
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')

        if not username or not password:
            error = "请输入账号密码！"
        else:
            try:
                conn = get_db_connection(DB_NAME_User)
                cursor = conn.cursor()

                cursor.execute("SELECT id FROM users WHERE username = %s", (username,))
                if cursor.fetchone():
                    error = "该用户名已被注册！"
                else:
                    hashed_password = generate_password_hash(password)
                    cursor.execute(
                        "INSERT INTO users (username, password) VALUES (%s, %s)",
                        (username, hashed_password)
                    )
                conn.close()
                flash("注册成功！","success")
                return redirect(url_for('login'))
            
            except Exception as e:
                error = f"system error:{str(e)}"
    
    return render_template('register.html', error = error)

@app.route('/login',methods=['GET', 'POST'])
def login():
    error = None
    messages = get_flashed_messages(with_categories=True)

    if messages:
        pass

    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')

        conn = get_db_connection(DB_NAME_User)
        cursor =  conn.cursor()

        cursor.execute("SELECT * FROM users WHERE username = %s", (username,))
        user = cursor.fetchone()
        conn.close()

        if user and check_password_hash(user['password'], password):
            session['logged_in'] = True
            session['user'] = user['username']
            return redirect(url_for('index'))
        else:
            error = '账号或者密码错误！'
        
    return render_template('login.html', error = error)

@app.route('/logout')
def logout():
    session.pop('logged_in', None)
    session.pop('user', None)
    return redirect(url_for('login'))


@app.route('/search')
def search():
    if not session.get('logged_in'):
        return redirect(url_for('login'))
    
    id = request.args.get('id','')

    if not id:
        return render_template('result.html', 
                               type='warning', 
                               message='NULL', 
                               details='没有输入！')
    
    safe_id = waf(id)

    if safe_id is None:
        return render_template('result.html', 
                               type='danger', 
                               message='WAF!!!', 
                               details='发现危险字符')
    
    try:
        conn = get_db_connection(DB_NAME_Data)
        cursor = conn.cursor()

        sql = f"SELECT id,username,gender,race FROM archives WHERE id = '{safe_id}'"

        cursor.execute(sql)
        result = cursor.fetchall()

        conn.close()

        MAX_LENGTH = 100
        
        limited_result = []
        if result:
            for row in result:
                new_row = {}
                for key, value in row.items():

                    str_val = str(value) 

                    if len(str_val) > MAX_LENGTH:
                        new_row[key] = str_val[:MAX_LENGTH]
                    else:
                        new_row[key] = value
                limited_result.append(new_row)
            
            return render_template('result.html', type='success', data=limited_result[:1])

        else:
            return render_template('result.html', 
                                   type='NOTHING', 
                                   message='未找到指定数据', 
                                   details=f'ID:"{safe_id}"并不在泰拉小动物中哦')

    except Exception as e:
        return render_template('result.html', 
                               type='Warning', 
                               message='SYSTEM ERROR', 
                               details=str(e))

if __name__ == '__main__':
    app.run(host='0.0.0.0', port = 1121) 