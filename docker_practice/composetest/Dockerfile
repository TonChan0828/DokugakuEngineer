FROM python:3.10-alpine
WORKDIR /code
ENV FLASK_RUN_HOST=0.0.0.0
COPY . .
RUN pip install -r requirements.txt
CMD ["flask", "run"]
