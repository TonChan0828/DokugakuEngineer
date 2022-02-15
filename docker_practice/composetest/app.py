from flask import Flask
import redis

app = Flask(__name__)
cache = redis.Redis(host='redis', port=6379)

@app.route('/')
def index():
  count = cache.incr('hits')
  return 'Hello! I have been seen {} times¥n'.format(count)
