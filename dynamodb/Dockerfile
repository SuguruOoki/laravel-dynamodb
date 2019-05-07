FROM amazon/dynamodb-local
WORKDIR /home/dynamodblocal
# UID=1000 → DynamoDB Local の実行ユーザ
RUN mkdir data && chown -R 1000 data
USER root
RUN yum -y install java-1.8.0-openjdk
