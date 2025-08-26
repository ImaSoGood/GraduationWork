import requests 
import json 
from bs4 import BeautifulSoup  

def parse_page(text):
    url = 'https://mnogotovarov.ru/search/?text=' + text
    response = requests.get(url)
    parsed_data = []  

    if response.status_code == 200:
        html = response.text
        soup = BeautifulSoup(html, 'html.parser')  

        cards = soup.find_all('div', class_='card')  

        for card in cards:
            image_url = ''
            id = card['id']
            title = card.find('div', class_='card__title').text.strip()
            image_element = card.find('img', class_='card__img')

            price_element = card.find('div', class_='price card__price')
            if price_element:
                price = price_element.text.strip().replace('\xa0', '').split()[0]  # Extract and clean price
            else:
                price = '0'

            if image_element:
                image_url = image_element.get('data-src', '')

            data = {
                'id': id,
                'title': title,
                'image_url': image_url,
                'price': price
            }

            parsed_data.append(data)

        json_data = json.dumps({'items': parsed_data}, ensure_ascii=False)
        print(json_data)
        
    else:
        print(json.dumps({'error': 'Ошибка при получении страницы', 'status_code': response.status_code, 'url': url}, ensure_ascii=False))

if __name__ == '__main__':
    import sys
    if len(sys.argv) > 1:
        text = sys.argv[1]
        parse_page(text)
        
        