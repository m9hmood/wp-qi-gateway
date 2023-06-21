<?php

abstract class QiCustomerOperations {
    const CREATE = 'create order';
    const PAYMENT = 'order payment';
}

abstract class QiOperationStatus {
    const SUCCESS = 'success';
    const FAIL = 'failed';
}