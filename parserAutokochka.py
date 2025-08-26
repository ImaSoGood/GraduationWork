# -*- coding: utf-8 -*-
import requests
import json
from bs4 import BeautifulSoup

#функция для парсинга
def parse_page(text):
    url = 'https://autokochka.ru/market/?q=' + text
    response = requests.get(url)
    parsed_data = []

    if response.status_code == 200:
        html = response.text
        soup = BeautifulSoup(html, 'html.parser')

        cards = soup.find_all('div', class_='sale-item')

        for card in cards:
            id = card.get('data-id')
            title = card.get('data-title')
            image_url = card.find('img', class_='js-sale-image').get('src')

            data = {
                'id': id,
                'title': title,
                'image_url': image_url
            }
            parsed_data.append(data)

        print(json.dumps(parsed_data))
    else:
        print(json.dumps({'error': 'Ошибка при получении страницы', 'status_code': response.status_code, 'url': url}))

if __name__ == '__main__':
    import sys
    if len(sys.argv) > 1:
        text = sys.argv[1]
        parse_page(text)


