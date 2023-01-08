<?php

abstract class QiCustomerOperations {
    const Create = 'create order';
    const Payment = 'order payment';
}

abstract class QiOperationStatus {
    const Success = 'success';
    const Fail = 'failed';
}