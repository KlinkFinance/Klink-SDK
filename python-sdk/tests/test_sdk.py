import pytest
from klinkfinance_sdk import KlinkSDK
from klinkfinance_sdk.types.exceptions import KlinkConfigException

def test_create_instance_missing_config():
    with pytest.raises(KlinkConfigException):
        KlinkSDK.create({})

def test_create_instance_invalid_health_check(mocker):
    # Mock the HttpClient.get method to raise an exception
    mock_get = mocker.patch('klinkfinance_sdk.core.HttpClient.get')
    mock_get.side_effect = Exception("Health check failed")

    with pytest.raises(Exception, match="Failed to initialize SDK: Health check failed"):
        KlinkSDK.create({
            "api_key": "test",
            "api_secret": "test"
        })

def test_create_quest_redirect_token(mocker):
    # Mock health check
    mock_get = mocker.patch('klinkfinance_sdk.core.HttpClient.get')
    mock_get.return_value = {"status": "ok"}
    
    client = KlinkSDK.create({
        "api_key": "test_key",
        "api_secret": "test_secret"
    })
    
    publisher = client.publisher()
    
    token_data = publisher.create_quest_redirect_token(
        {
            "offerId": "123",
            "sub": "user1",
            "pub": "pub1"
        },
        "test_secret"
    )
    
    assert "token" in token_data
    assert "expiresAt" in token_data

