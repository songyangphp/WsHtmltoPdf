[toc]
## 网页生成PDF服务：

使用之前务必初始化sign(全局有效)

项目唯一码获取方式(去文始技术基础业务管理后台申请或联系管理员)
```php
HtmlToPdf::setSign('您的项目唯一码');
```

### 一，同步生成PDF 

```php

/**
* url 必须 要生成pdf的html链接地址
* file_id 必须 pdf文件唯一标识
* type 可选[base64,url] 返回格式 默认为base64格式
*/

HtmlToPdf::syncCreatePdf("https://www.baidu.com/",8002,'url');
```

### 二，异步生成PDF 

```php

/**
* url 必须 要生成pdf的html链接地址
* notify_url 必须 生成成功所请求的异步地址
* type 可选[base64,url] 返回格式 默认为base64格式
*/

HtmlToPdf::asynCreatePdf("https://www.baidu.com","http://zc.wszx.cc/songtest-pdf.html",'url');