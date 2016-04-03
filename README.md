[![Build Status](https://travis-ci.org/keinewaste/keinewaste.svg?branch=master)](https://travis-ci.org/keinewaste/keinewaste)

# KEINE WASTE

# Local development

Install vagrant, and execute this command on root folder:


```
vagrant up
```

Default mysql login:
user: root
password: no password


To build:

```
ant build -Denv=dev
```

To run tests:

```
ant test
```


# Create Cloudformation stack

```
aws cloudformation create-stack --capabilities=CAPABILITY_IAM --stack-name KeineWasteAPI --template-body file://${PWD}/aws/resources.json --parameters ParameterKey=ApiAMI,ParameterValue=ami-80bf3ef3 ParameterKey=DefaultVpc,ParameterValue=vpc-a6f773c3
```




