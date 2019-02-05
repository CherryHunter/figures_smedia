import bs4, requests, os, time, mysql.connector, datetime
from dateutil import parser
from fuzzywuzzy import fuzz

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="figures_webapp"
)

mycursor = mydb.cursor()

url = "https://www.biginjap.com/en/index.php?controller=new-products"

def load_figure(link):
    soup = bs4.BeautifulSoup(requests.get(link).text,'lxml')

    #pobieranie danych ze strony
    details = soup.find(id="idTab1").find_all("p")

    maker = ""
    date = ""
    title = ""

    for detail in details:

        spaceless = detail.text.replace(' ','').replace(u"\xa0","")
        if spaceless.find("Manufacturer")!= -1: maker = spaceless[13:]
        elif spaceless.find("AVAILABILITY")!= -1:
            try:
                date = parser.parse(spaceless[13:])
                date = date.strftime('%Y-%m-%d')
            except:
                return

    title = soup.find(id="pb-left-column").find("h1").text
    if not maker or not date or not title: return

    price = soup.find(id="our_price_display").text[:-1]
    price = price.replace(' ','')

    #porównywanie wartości z tymi w bazie

    sql = "SELECT `title`, maker, `date`, id FROM figures"
    mycursor.execute(sql)
    figure_data = mycursor.fetchall()
    ratio = 0
    ratio_m = 0
    corr_date = False
    figure_id = 0

    for figure in figure_data:
        fuzzy = fuzz.ratio(figure[0], title)
        if fuzzy > ratio:
            ratio = fuzzy
            figure_id = figure[3]

        fuzzy_m = fuzz.ratio(figure[1], maker)
        if fuzzy_m > ratio_m: ratio_m = fuzzy_m

        if date[:-3] == str(figure[2])[:-3]: corr_date = True

    if ratio > 50 and ratio_m > 60 and corr_date:

        sql = "SELECT id FROM shops where name = 'biginjapan' "
        mycursor.execute(sql)
        shop_id = mycursor.fetchone()

        sql = "SELECT id from `sales` WHERE `price` = %s and `figure_id` = %s and `shop_id` = %s "
        chr = (price, figure_id, shop_id[0])
        mycursor.execute(sql, chr)
        is_it = mycursor.fetchone()
        if is_it != None: return

        sql = "INSERT INTO sales (`price`, created_at, figure_id, shop_id) VALUES (%s, %s, %s, %s)"
        val = (price, datetime.datetime.today().strftime('%Y-%m-%d'), figure_id, shop_id[0])
        mycursor.execute(sql, val)
        mydb.commit()
        print(mycursor.rowcount, "record inserted.")

def load_shop():
    soup = bs4.BeautifulSoup(requests.get(url).text,'lxml')
    products = soup.find_all("div",class_='center_block')
    links = []
    for product in products:
        link = product.find("a")['href']
        links.append(link)
        load_figure(link)

load_shop()
